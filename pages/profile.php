<?php
declare(strict_types = 1);

require_once(dirname(__DIR__).'/templates/common.tpl.php');
require_once(dirname(__DIR__).'/templates/profile.tpl.php');
require_once(dirname(__DIR__).'/classes/class.user.php');
require_once(dirname(__DIR__).'/database/database.connection.php');
require_once(dirname(__DIR__).'/classes/class.session.php');

drawHead();

$session = new Session();
if (!$session->isLoggedIn()) {
  $message = "Please log in to access this page.";
  header("Location: login.php?message=" . urlencode($message));
  exit;
}

$db = getDatabaseConnection();
$user = User::getUser($db, $session->getId());

  if ($user->role === "agent") {
    drawSideBarAgent($user);
    drawProfileAgent($user);
  }
  else if ($user->role === "admin") {
    drawSideBarAdmin($user);
    drawProfile($user);
  }
  else {
    drawSideBar($user);
    drawProfile($user);
  }
  
  drawFooter();
?>