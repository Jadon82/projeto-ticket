<?php

class Ticket implements JsonSerializable
{

  private static $_categories = array(
    'rh' => 'Recursos Humanos',
    'ti' => 'TI',
    'fin' => 'Financeiro',
    'jur' => 'Juríduco',
    'inf' => 'Infraestrutura'
  );

  private const STATUS_OPEN = 0;
  private const STATUS_WORKING = 1;
  private const STATUS_DONE = 2;

  private static $_status_list = array(
    0 => 'Aberto',
    1 => 'Em andamento',
    2 => 'Fechado'
  );

  public function __construct()
  {
    $categories = self::getCategories();
    $this->type_desc = $categories[$this->ticket_type];
    $this->status_text = self::$_status_list[$this->status];
  }

  public function jsonSerialize()
  {
    return $this;
  }

  public static function getCategories()
  {
    return self::$_categories;
  }

  public static function getStatusList()
  {
    return self::$_status_list;
  }

  public static function create($data, $status = self::STATUS_OPEN)
  {
    $db = Db::getConnection();

    $categories = self::getCategories();

    if (!$data) {
      throw new Exception('Invalid ticket data');
    }

    if (!array_key_exists($data['ticket_type'], $categories)) {
      throw new Exception('Invalid ticket type');
    }

    if (!array_key_exists($status, self::$_status_list)) {
      throw new Exception('Invalid status');
    }

    $insert = 'INSERT INTO tickets (title, ticket_type, description, reported_by, responsable, status, created_at) VALUES ';
    $insert .= '(:title, :ticket_type, :description, :reported_by, :responsable, :status, CURRENT_TIMESTAMP)';
    $stmt = $db->prepare($insert);
    $stmt->bindParam(':title', $data['title']);
    $stmt->bindParam(':ticket_type', $data['ticket_type']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':reported_by', $data['reported_by']);
    $stmt->bindParam(':responsable', $data['responsable']);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);

    $ok = $stmt->execute();

    if (!$ok) {
      throw new Exception('Error on create Ticket');
    }

    $id_ticket = $db->lastInsertId();

    $ticket = TicketApp::getTicket($id_ticket);

    $ticket->createHistory('Chamado Criado');

    return $ticket;
  }

  public function __toString()
  {
    ob_start();
    $ticket = $this;
    include(APP_PATH . '/templates/ticket_row.php');
    $text = ob_get_contents();
    ob_end_clean();
    return $text;
  }

  public function listHistory()
  {
    $db = DB::getConnection();
    $stmt = $db->query("SELECT * FROM tickets_history where id_ticket = {$this->id_ticket}");
    $history = $stmt->fetchAll(PDO::FETCH_CLASS, TicketHistory::class);
    return $history;
  }

  public function createHistory($comment, $newResponsable = null, $newStatus = null)
  {
    $db = Db::getConnection();

    if ($newStatus) {
      if (!array_key_exists($newStatus, self::$_status_list)) {
        throw new Exception('Invalid status');
      }
    } else {
      $newStatus = $this->status;
    }

    // if (!$newResponsable) {
    //   $newResponsable = $this->responsable;
    // }

    if (empty($comment)) {
      throw new Exception('Comment can not be blank');
    }

    $insert = 'INSERT INTO tickets_history (id_ticket, description, status, created_at) VALUES ';
    $insert .= "(:id_ticket, :description, :status, CURRENT_TIMESTAMP)";
    $stmt = $db->prepare($insert);
    $stmt->bindParam(':id_ticket', $this->id_ticket, PDO::PARAM_INT);
    $stmt->bindParam(':description', $comment);
    $stmt->bindParam(':status', $newStatus, PDO::PARAM_INT);

    $ok = $stmt->execute();

    if (!$ok) {
      throw new Exception('Error on create Ticket');
    }

    $id_history = $db->lastInsertId();

    $history = TicketApp::getTicketHistory($id_history);

    $this->updateStatus($newStatus, $newResponsable);

    return $history;
  }

  public function updateStatus($status, $newResponsable = null)
  {
    $status = (int) $status;

    $changed = false;
    if ($this->status !== $status) {
      $changed = true;
      $this->status = $status;
      $this->status_text = self::$_status_list[$this->status];
    }

    if ($newResponsable && $this->responsable !== $newResponsable) {
      $changed = true;
      $this->responsable = $newResponsable;
      $this->createHistory("Alterado responsável para: $newResponsable");
    }

    $db = Db::getConnection();
    if (!array_key_exists($status, self::$_status_list)) {
      throw new Exception('Invalid status');
    }


    if ($changed) {
      $queryUpdate = 'update tickets set ';
      $queryUpdate .= ' status = :status, ';
      $queryUpdate .= ' responsable = :responsable ';
      $queryUpdate .= ' where id_ticket = :id_ticket';
      $stmt = $db->prepare($queryUpdate);
      $stmt->bindParam(':id_ticket', $this->id_ticket, PDO::PARAM_INT);
      $stmt->bindParam(':responsable', $this->responsable);
      $stmt->bindParam(':status', $this->status, PDO::PARAM_INT);

      return $stmt->execute();
    }

    return false;
  }
}
