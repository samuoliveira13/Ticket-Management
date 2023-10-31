<?php
declare(strict_types = 1);

require_once(dirname(__DIR__).'/classes/class.session.php');
require_once(dirname(__DIR__).'/classes/class.user.php');
require_once(dirname(__DIR__).'/classes/class.ticket.php');
require_once(dirname(__DIR__).'/templates/common.tpl.php');
require_once(dirname(__DIR__).'/templates/ticket.tpl.php');
require_once(dirname(__DIR__).'/database/database.connection.php');

  drawHead();

  $session = new Session();
  if (!$session->isLoggedIn()) {
    $message = "Please log in to access this page.";
    header("Location: login.php?message=" . urlencode($message));
    exit;
  }

  $db = getDatabaseConnection();
  $user = User::getUser($db, $session->getId());
  $tickets = Ticket::getTickets($db, $user->id);

  error_log("session_id: ". $session->getId());


    if ($user->role == "admin"){
      drawSideBarAdmin($user);
      $tickets = Ticket::getAllTicketsAdmin($db);
      //var_dump($tickets);
      drawAllTickets($db, $tickets);
    } else {
      header('Location: tickets.php');
    }

    drawFooter();
?>