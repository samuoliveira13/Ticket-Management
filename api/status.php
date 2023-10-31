<?php

        require_once(dirname(__DIR__).'/database/database.connection.php');
        $db = getDatabaseConnection();

        $stmt = $db->prepare('SELECT DISTINCT status FROM tickets');
        $stmt->execute();
        $status = $stmt->fetchAll();
    
        
        header("Content-Type: application/json");
        echo json_encode($status);

?>
