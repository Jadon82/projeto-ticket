<?php

class TicketApp
{

  private static $config;

  public static function start($config)
  {
    self::$config = $config;
    DB::setEnv($config);
  }

  public static function getTicket($ticketId, $loadHistory = false)
  {
    $db = DB::getConnection();
    $ticketId = is_numeric($ticketId) ? $ticketId : 0;
    $stmt = $db->query("SELECT * FROM tickets where id_ticket = {$ticketId}");
    $stmt->setFetchMode(PDO::FETCH_CLASS, Ticket::class);
    $ticket = $stmt->fetch();

    if ($loadHistory) {
      $ticket->history = $ticket->listHistory();
    }
    return $ticket;
  }

  public static function getTicketHistory($historyId)
  {
    $db = DB::getConnection();
    $historyId = is_numeric($historyId) ? $historyId : 0;

    $stmt = $db->query("SELECT * FROM tickets_history where id_history = {$historyId}");
    $stmt->setFetchMode(PDO::FETCH_CLASS, TicketHistory::class);
    $ticketHistory = $stmt->fetch();
    return $ticketHistory;
  }

  public static function listTickets($responsable = '', $status = null)
  {
    $db = DB::getConnection();
    $stmt = $db->query('SELECT * FROM tickets');

    $tickets = $stmt->fetchAll(PDO::FETCH_CLASS, Ticket::class);

    return $tickets;
  }

  public static function createSqliteDB()
  {
    header('Content-Type: text/plain');
    $db = Db::getConnection();

    $commands = array();

    $commands[] = <<<EOT
    DROP TABLE IF EXISTS tickets
EOT;

    $commands[] = <<<EOT
    DROP TABLE IF EXISTS tickets_history
EOT;

    $commands[] = <<<EOT
    CREATE TABLE tickets (
      id_ticket INTEGER PRIMARY KEY,
      title TEXT,
      ticket_type TEXT,
      description TEXT,
      reported_by TEXT,
      responsable TEXT,
      status INTEGER,
      created_at INTEGER
    )
EOT;

    $commands[] = <<<EOT
    CREATE TABLE tickets_history (
      id_history INTEGER PRIMARY KEY,
      id_ticket INTEGER,
      description TEXT,
      status INTEGER,
      created_at INTEGER
    )
EOT;

    $commands[] = <<<EOT
    CREATE INDEX ticket_idx_status ON tickets (status)
EOT;

    $commands[] = <<<EOT
    CREATE INDEX history_idx_ticket ON tickets_history (id_ticket)
EOT;

    echo 'setupDB >>> ' . PHP_EOL;

    foreach ($commands as $command) {

      echo $command . PHP_EOL;

      var_dump($db->exec($command));
    }
  }
}
