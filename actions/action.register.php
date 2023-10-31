<?php
    declare(strict_types = 1);
    require_once(dirname(__DIR__).'/database/database.connection.php');
    require_once(dirname(__DIR__).'/classes/class.session.php');
    $session = new Session();

    $_SESSION['input']['name register'] = htmlentities($_POST['name']);
    $_SESSION['input']['morada register'] = htmlentities($_POST['username']);
    $_SESSION['input']['email register'] = htmlentities($_POST['email']);
    $_SESSION['input']['password register'] = htmlentities($_POST['password']);
    $_SESSION['input']['confirm_password register'] = htmlentities($_POST['confirm_password']);

    $db = getDatabaseConnection();
    if ($_POST['password'] === $_POST['confirm_password']) {

        $cost = ['cost' => 12];
        $stmt = $db->prepare('INSERT INTO users (name, username, email, password, role) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute(array($_POST['name'], $_POST['username'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT, $cost), 'client'));

    } else {
        $session->addMessage('Warning', "Passwords don't mactch");
        die(header('Location: ../pages/register.php'));
    }

    unset($_SESSION['input']);

    $session->addMessage('Success', "Registration Completed!");
    header('Location: ../pages/login.php');
?>