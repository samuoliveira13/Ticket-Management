<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../classes/class.session.php');
    require_once(__DIR__ . '/../classes/class.user.php');
    require_once(__DIR__ . '/../database/database.connection.php');
    $session = new Session();

    $_SESSION['input']['username login'] = htmlentities($_POST['username']);
    $_SESSION['input']['password login'] = htmlentities($_POST['password']);

    $db = getDatabaseConnection();

    $user = User::getUserWithPassword($db, $_POST['username'], $_POST['password']);

    if ($user) {
        $_SESSION['id'] = $user->id;
        $_SESSION['name'] = $user->getName();

        unset($_SESSION['input']['username login']);
        unset($_SESSION['input']['password login']);
        $session->addMessage('sucess', 'Login was sucessful! Welcome!');
        header('Location: ../pages/profile.php');
    } else {
        $session->addMessage('error' , 'Wrong password, please try again');
        die(header("Location: ../pages/login.php"));
    }
?>