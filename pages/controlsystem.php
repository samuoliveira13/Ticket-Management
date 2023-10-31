<?php
declare(strict_types=1);
require_once(dirname(__DIR__).'/classes/class.session.php');
require_once(dirname(__DIR__).'/classes/class.user.php');
require_once(dirname(__DIR__).'/classes/class.ticket.php');
require_once(dirname(__DIR__).'/templates/common.tpl.php');
require_once(dirname(__DIR__).'/templates/ticket.tpl.php');
require_once(dirname(__DIR__).'/database/database.connection.php');

$db = getDatabaseConnection();
$session = new Session();
$user = User::getUser($db, $session->getId());
$tickets = Ticket::getTickets($db, $user->id);

error_log("session_id: ". $session->getId());

drawHead();

if ($user->role == "admin") {
    drawSideBarAdmin($user);
    drawSystem($user);
}

drawFooter();
?>
