<?php
    require_once(dirname(__DIR__).'/database/database.connection.php');
    require_once(dirname(__DIR__).'/classes/class.user.php');

    $db = getDatabaseConnection();
    $comment_text = $_POST['comment_text'];
    $date = date('Y-m-d H:i:s');
    $ticket_id=intval($_POST['ticket_id']);
    $user_id=intval($_POST['user_id']);

    error_log('comment_text no postcomment: '.$comment_text);
    error_log('ticket_id no postcomment: '.$ticket_id);

    $stmt=$db->prepare("INSERT INTO comment (comment_id,description, date, ticket_id,user_id) VALUES (:comment_id,:comment, :chrono, :ticket_id,:user_id)");
    $stmt->bindParam(':comment',$comment_text);
    $stmt->bindParam(':chrono',$date);
    $stmt->bindParam(':ticket_id',$ticket_id);
    $stmt->bindParam(':user_id',$user_id);
    $stmt->bindParam(':comment_id',$comment_id);

    $stmt->execute();

    $user_name=User::getUser($db,$user_id)->name;


    $comment_object=[];
    array_push($comment_object,$comment_text,$user_name,$date);



    echo json_encode($comment_object);
?>