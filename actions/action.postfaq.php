<?php
    require_once(dirname(__DIR__).'/database/database.connection.php');
    require_once(dirname(__DIR__).'/classes/class.faq.php');

    $db = getDatabaseConnection();
    $faq_question = $_POST['post_faq_question'];
    $faq_answer = $_POST['post_faq_answer'];
    error_log('faq_question: '.$faq_question);
    error_log('faq_answer: '.$faq_answer);

    $stmt = $db->prepare("INSERT INTO faq (question, answer) VALUES (:question, :answer)");
    $stmt->bindParam(':question',$faq_question);
    $stmt->bindParam(':answer',$faq_answer);


    $stmt->execute();

    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        error_log("New FAQ added. Rows affected: " . $rowCount);
        } else {
        error_log("Failed adding new FAQ. No rows affected.");
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
?>