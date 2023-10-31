<?php
    declare(strict_types = 1);

    require_once(dirname(__DIR__).'/templates/common.tpl.php');
    require_once(dirname(__DIR__).'/database/database.connection.php');
    require_once(dirname(__DIR__).'/classes/class.session.php');
    require_once(dirname(__DIR__).'/classes/class.user.php');
    require_once(dirname(__DIR__).'/classes/class.department.php');
    require_once(dirname(__DIR__).'/templates/users.tpl.php');

    drawHead();

    $session = new Session();
    if (!$session->isLoggedIn()) {
      $message = "Please log in to access this page.";
      header("Location: login.php?message=" . urlencode($message));
      exit;
    }


    $db = getDatabaseConnection();
    $user = User::getUser($db, $session->getId());
    $users = User::getUsers($db);

    error_log("session_id: ". $session->getId());
    if($user->role !== "admin"){
        header('Location: profile.php');
    }

    drawSideBarAdmin($user);
    drawAllUsers($db, $users, $user->id);
    drawFooter();
?>