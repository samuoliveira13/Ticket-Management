<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/classes/class.session.php');
  $session = new Session();

  unset($_SESSION['input']['username login']);
  unset($_SESSION['input']['password login']);
  if ($session->isLoggedIn()) $session->logout();
  header('Location: ../pages/login.php');
?>