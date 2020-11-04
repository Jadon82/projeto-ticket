<?php
require_once '../bootstrap.php';
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Projeto</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Jadon Martins">
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="css/app.css">
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>

<body>
  <div class="container">
    <?php
      if ($page === 'cadastro') {
        $ticket_types = Ticket::getCategories();
        require_once(APP_PATH . '/templates/cadastro.php');
      } else if ($page === 'detalhes_chamado') {
        $ticket = TicketApp::getTicket($_GET['id_ticket'], true);
        require_once(APP_PATH . '/templates/detalhes.php');
      } else {
        $tickets = TicketApp::listTickets();
        require_once(APP_PATH . '/templates/listagem.php');
      }
    ?>
  </div>
  <script>

  </script>
</body>

</html>
