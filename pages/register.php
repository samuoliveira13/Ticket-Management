<?php
    declare(strict_types=1);
    require_once(dirname(__DIR__).'/templates/common.tpl.php');
    require_once(dirname(__DIR__).'/classes/class.session.php');
    $session = new Session();

    $_SESSION['input']['name register'] = $_SESSION['input']['name register'] ?? "";
    $_SESSION['input']['username register'] = $_SESSION['input']['username register'] ?? "";
    $_SESSION['input']['email register'] = $_SESSION['input']['email register'] ?? "";
    $_SESSION['input']['password register'] = $_SESSION['input']['password register'] ?? "";
    $_SESSION['input']['confirm_password register'] = $_SESSION['input']['confirm_password register'] ?? "";

    drawHead();
    drawLogReg();
    if (count($session->getMessages())) drawMessages($session);
    drawRegisterForm();
?>