<?php
declare(strict_types = 1);
require_once(dirname(__DIR__).'/classes/class.session.php');
require_once(dirname(__DIR__).'/classes/class.user.php');
require_once(dirname(__DIR__).'/classes/class.ticket.php');
require_once(dirname(__DIR__).'/templates/common.tpl.php');
require_once(dirname(__DIR__).'/templates/ticket.tpl.php');
require_once(dirname(__DIR__).'/database/database.connection.php');
require_once(dirname(__DIR__).'/classes/class.department.php');

  $db = getDatabaseConnection();
  $session = new Session();
  $user = User::getUser($db, $session->getId());
  
  $ticket_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
  $ticket=Ticket::getTicket($db, $ticket_id);

  $ticket_creator = User::getUser($db,$ticket->user_id);
  $department_name = Department::getDepartmentName($db,$ticket->department_id);

  $ticket_changes=Ticket::getTicketChanges($ticket_id);

  error_log("session_id: ". $session->getId());

    drawHead();

    if ($user->role == "agent") {
        drawSideBarAgent($user);
        drawTicketChanges($ticket_changes,$ticket_creator);
      }
      else if ($user->role == "admin") {
        drawSideBarAdmin($user);
        drawTicketChanges($ticket_changes,$ticket_creator);
      }
      else {
        drawSideBar($user);
        drawTicketChanges($ticket_changes,$ticket_creator);
    }
      


    
    

    drawFooter();
?>