<?php
require_once '../bootstrap.php';

$valid_actions = array('get_ticket', 'create_ticket', 'create_history');

$action = in_array($_GET['action'], $valid_actions) ? $_GET['action'] : false;

// POST /ticket.php?action=create_ticket
if ($action === 'create_ticket') {
  try {
    $ticket = Ticket::create($_POST);
    header("Location: " . BASE_URL . "?page=detalhes_chamado&id_ticket={$ticket->id_ticket}");
    // http_response_code(201);
    // echo json_encode($ticket);
  } catch (Exception $ex) {
    http_response_code(500);
    echo $ex->getMessage();
  }
}

// GET /ticket.php?action=get_ticket&id_ticket=99&detail=1
if ($action === 'get_ticket') {
  $loadHistory = isset($_GET['detail']) && $_GET['detail'] > 0 ? true : false;
  $ticket = TicketApp::getTicket($_GET['id_ticket'], $loadHistory);
  echo json_encode($ticket, JSON_PRETTY_PRINT);
}

// POST /ticket.php?action=create_history
if ($action === 'create_history') {
  $id_ticket = isset($_POST['id_ticket'])
    && is_numeric($_POST['id_ticket']) ? $_POST['id_ticket'] : 0;

  try {
    $ticket = TicketApp::getTicket($id_ticket);
    $ticket->createHistory($_POST['comment'], $_POST['responsable'], $_POST['status']);
    header("Location: " . BASE_URL . "?page=detalhes_chamado&id_ticket={$ticket->id_ticket}");
  } catch (Exception $ex) {
    http_response_code(500);
    echo $ex->getMessage();
  }
}

if (!$action) {
  http_response_code(501);
  exit(0);
}

exit(0);
