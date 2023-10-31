<?php
declare(strict_types = 1);

  require_once(dirname(__DIR__).'/templates/common.tpl.php');
  require_once(dirname(__DIR__).'/templates/ticket.tpl.php');
  require_once(dirname(__DIR__).'/classes/class.ticket.php');
  require_once(dirname(__DIR__).'/database/database.connection.php');
  require_once(dirname(__DIR__).'/classes/class.session.php');
  require_once(dirname(__DIR__).'/classes/class.user.php');
  require_once(dirname(__DIR__).'/classes/class.department.php');

  drawHead();

  $session = new Session();
  if (!$session->isLoggedIn()) {
    $message = "Please log in to access this page.";
    header("Location: login.php?message=" . urlencode($message));
    exit;
  }

  $db = getDatabaseConnection();
  $user = User::getUser($db, $session->getId());

  $ticket_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
  $ticket=Ticket::getTicket($db, $ticket_id);

  $ticket_creator = User::getUser($db,$ticket->user_id);
 
  $agents = User::getAgents($db);
  $comments = Ticket::getComments($db, $ticket_id);
  $department = Department::getDepartment($db,$ticket->department_id);
  $hashtags = $ticket->getHashtags();
  
  error_log("session_id: ". $session->getId());

    drawHead();

    if ($user->role == "agent") {
          drawSideBarAgent($user);

          if ($ticket->assigned_to == NULL) {
            drawTicket_new($ticket, $department->name, $comments, $ticket_creator, $user, NULL, $hashtags, $agents);
          } 
          else {
            $assinged_to = User::getUser_name($db, $ticket->assigned_to);
            drawTicket_new($ticket, $department->name, $comments, $ticket_creator, $user, $assinged_to, $hashtags, $agents);
          }
    
    } else if ($user->role == "admin") {
          drawSideBarAdmin($user);

          if ($ticket->assigned_to == NULL) {
            drawTicket_new($ticket, $department->name, $comments, $ticket_creator, $user, NULL, $hashtags, $agents);
          } 
          else {
            $assinged_to = User::getUser_name($db, $ticket->assigned_to);
            drawTicket_new($ticket, $department->name, $comments, $ticket_creator, $user, $assinged_to, $hashtags, $agents);
          }
    }
    else {
          drawSideBar($user);

          if ($ticket->assigned_to == NULL) {
            drawTicket_new_User($ticket, $department->name, $comments,$ticket_creator, NULL ,$hashtags);
          }
          else {
            $agent = User::getUser($db, $ticket->assigned_to);
            drawTicket_new_User($ticket, $department->name, $comments,$ticket_creator, $agent,$hashtags);
          }
    }

    drawFooter();
?>