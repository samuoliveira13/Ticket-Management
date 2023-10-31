<?php
declare(strict_types = 1);
require_once(dirname(__DIR__).'/classes/class.session.php');
require_once(dirname(__DIR__).'/classes/class.user.php');
require_once(dirname(__DIR__).'/classes/class.ticket.php');
require_once(dirname(__DIR__).'/templates/common.tpl.php');
require_once(dirname(__DIR__).'/templates/ticket.tpl.php');
require_once(dirname(__DIR__).'/database/database.connection.php');

$db = getDatabaseConnection();
$session = new Session();
$user = User::getUser($db, $session->getId());

$response = ["success" => false];

if ($user) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['status'])) {
            $newStatus = $_POST['status'];
            Ticket::$Statuses[] = $newStatus;
            $response["success"] = true;
            $response["message"] = "New status added: " . $newStatus;
        } elseif (isset($_POST['priority'])) {
            $newPriority = $_POST['priority'];
            Ticket::$Priorities[] = $newPriority;
            $response["success"] = true;
            $response["message"] = "New priority added: " . $newPriority;
        } elseif (isset($_POST['department'])) {
            $newDepartment = $_POST['department'];
            $response["success"] = true;
            $response["message"] = "New department added: " . $newDepartment;
        }
    } else {
        $response["error"] = "Invalid request method.";
    }
} else {
    $response["error"] = "User not found.";
}

error_log(json_encode($response));

$_SESSION['response'] = $response;
header('Location: ../pages/controlsystem.php');
exit();
?>
