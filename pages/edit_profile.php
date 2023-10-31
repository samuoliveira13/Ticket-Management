<?php
    declare(strict_types=1);

    require_once(dirname(__DIR__).'/database/database.connection.php');
    require_once(dirname(__DIR__).'/classes/class.user.php');
    require_once(dirname(__DIR__).'/classes/class.session.php');
    require_once(dirname(__DIR__).'/templates/profile.tpl.php');
    require_once(dirname(__DIR__).'/templates/common.tpl.php');

    drawHead();

    $session = new Session();
    if (!$session->isLoggedIn()) {
        $message = "Please log in to access this page.";
        header("Location: login.php?message=" . urlencode($message));
        exit;
    }

    $db = getDatabaseConnection();
    $user = User::getUser($db, $session->getId());


    $_SESSION['input']['user id'] = $_SESSION['input']['user id'] ?? $user->id;
    $_SESSION['input']['name edit'] = $_SESSION['input']['name edit'] ?? $user->name;
    $_SESSION['input']['username edit'] = $_SESSION['input']['username edit'] ?? $user->username;
    $_SESSION['input']['email edit'] = $_SESSION['input']['email edit'] ?? $user ->email;
    $_SESSION['input']['old_password edit'] = $_SESSION['input']['old_password edit'] ?? "";
    $_SESSION['input']['new_password edit'] = $_SESSION['input']['confirm_password edit'] ?? "";

    if ($user->role == "agent") {
        drawSideBarAgent($user);
    }
    else if ($user->role == "admin") {
        drawSideBarAdmin($user);
    }
    else {
        drawSideBar($user);
    }
    
    drawEditProfile($user);
    drawFooter();

?>