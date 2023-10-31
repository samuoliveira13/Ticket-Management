<?php

        require_once(dirname(__DIR__).'/database/database.connection.php');
        $db = getDatabaseConnection();

        $stmt = $db->prepare('SELECT * from departments');
        $stmt->execute();
        $departments = $stmt->fetchAll();


        header("Content-Type: application/json");
        echo json_encode($departments);

?>
