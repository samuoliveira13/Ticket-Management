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

    $response = ["success" => false];
    if ($user) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userId = $_POST['userId'];
            $currentUser = User::getUser($db, (int) $userId);

            if (isset($_POST['role'])) {
                $currentUser->role = $_POST['role'];
            }
            if (isset($_POST['department_id'])) {
                $department = $_POST['department_id'];
                $currentUser->department_id = Department::getDepartmentIdByName($db, $department);
            }

            if($currentUser->role === "admin" || $currentUser->role === "user"){
                $currentUser->department_id = 6;
            }
            
            if ($currentUser->saveAdmin($db)) {
                $response["success"] = true;
            } else {
                $response["error"] = "Failed to save user data.";
            }

        } else {
            $response["error"] = "Invalid request method.";
        }
    } else {
        $response["error"] = "User not found.";
    }



    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
?>
