<?php

include_once 'app/config.php';
include_once 'app/Db.php';
include_once 'app/Ticket.php';
include_once 'app/TicketHistory.php';
include_once 'app/TicketApp.php';

TicketApp::start($config);

if (isset($_GET['_setupDB'])) {
  TicketApp::createSqliteDB();
  exit(0);
}

$page = isset($_GET['page']) ? $_GET['page'] : false;


// $ticket = Ticket::create(array(
//   'title' => 'Chamado',
//   'ticket_type' => 'fin',
//   'description' => 'Descrição',
//   'reported_by' => 'Jadon',
//   'responsable' => 'José',
// ));

// $history = $ticket->createHistory('Ok, verificando', 1);

// var_dump($ticket->listHistory());

// $tickets = TicketApp::listTickets();
// echo json_encode($tickets, JSON_PRETTY_PRINT);

// $ticket = TicketApp::getTicket(1);
// print_r($ticket);
// echo $ticket;


// exit(0);
