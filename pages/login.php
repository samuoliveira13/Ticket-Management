<?php
    declare(strict_types=1);
    require_once(dirname(__DIR__).'/templates/common.tpl.php');
    require_once(dirname(__DIR__).'/classes/class.session.php');
    $session = new Session();

    $_SESSION['input']['username login'] = $_SESSION['input']['username login'] ?? "";
    $_SESSION['input']['password login'] = $_SESSION['input']['password login'] ?? "";

    $message = $_GET['message'] ?? '';

    drawHead();
    drawLogReg();
    if (count($session->getMessages())) drawMessages($session);
    drawLoginForm();
    
?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    <?php if ($message) { ?>
      alert("<?php echo htmlspecialchars($message); ?>");
    <?php } ?>
  });
</script>