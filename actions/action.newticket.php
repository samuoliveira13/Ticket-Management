<?php
    declare(strict_types = 1);
    require_once(dirname(__DIR__).'/database/database.connection.php');
    require_once(dirname(__DIR__).'/classes/class.session.php');
    require_once(dirname(__DIR__).'/classes/class.user.php');
    
    $session = new Session();
    $db = getDatabaseConnection();
    $user_id = $session->getId();
    $date = date('d-m-Y');
    
    
    $_SESSION['input']['title newticket'] = htmlentities($_POST['title']);
    $_SESSION['textarea']['description newticket'] = htmlentities($_POST['description']);
    $_SESSION['select']['department newticket'] = htmlentities($_POST['department']);
    $_SESSION['select']['priority newticket'] = htmlentities($_POST['priority']);
    
    $stmt = $db->prepare('INSERT INTO tickets (user_id, title, description, date, status, priority, department_id) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute(array($user_id, $_POST['title'], $_POST['description'], $date, 'Open', $_POST['priority'], $_POST['department']));
    
    header('Location: ../pages/profile.php');
?>