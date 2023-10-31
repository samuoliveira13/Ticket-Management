<?php
    declare(strict_types=1);
    require_once(dirname(__DIR__).'/database/database.connection.php');
    require_once(dirname(__DIR__).'/classes/class.user.php');
    require_once(dirname(__DIR__).'/classes/class.session.php');
    require_once(dirname(__DIR__).'/templates/common.tpl.php');
    require_once(dirname(__DIR__).'/templates/profile.tpl.php');

    $session = new Session();
    
    $db = getDatabaseConnection();

    $user = User::getUser($db, $session->getId());

    $ticket_id = $_POST['ticket_id'];
    $user_id = $_POST['user_id'];

    $stmt = $db->prepare('UPDATE tickets SET assigned_to = :user_id WHERE ticket_id = :ticket_id');
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':ticket_id', $ticket_id);
    $stmt->execute();

    header('Location: ../pages/tickets.php');
?>