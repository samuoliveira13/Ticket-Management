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

    if ($user) {
        $user->name = $_POST['name'];
        $user->username = $_POST['username'];
        $user->email = $_POST['email'];
        $cost = ['cost' => 12];
        $user->password = password_hash($_POST['new_password'], PASSWORD_DEFAULT, $cost);

        $user->save($db);
    }

    header('Location: ../pages/profile.php');

?>