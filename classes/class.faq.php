<?php
declare(strict_types = 1);
require_once(dirname(__DIR__).'/database/database.connection.php');
$db = getDatabaseConnection();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'addFaq') {
  
    $faq_question = $_POST['faq_question'];
    $faq_answer = $_POST['faq_answer'];
    error_log("faq_question na class faq: ".$faq_question);
    error_log("faq_answer na class faq: ".$faq_answer);

    FAQ::addFaq($faq_question,$faq_answer);
}

class FAQ{

    public int $faq_id;
    public string $question;
    public string $answer;
   

    public function __construct(int $faq_id, string $question, string $answer)
    {
        $this->faq_id=$faq_id;
        $this->question=$question;
        $this->answer=$answer;
        
    }


    static public function getAllfaqs() {
        global $db;
    
        $stmt = $db->prepare('SELECT * FROM faq');
        $stmt->execute();
    
        $faqs = [];
        $rowCount = 0;
    
        while ($faq = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $faqs[] = new FAQ(intval($faq['faq_id']), $faq['question'], $faq['answer']);
            $rowCount++;
        }
    
        if ($rowCount > 0) {
            error_log("Got all FAQs. Rows affected: " . $rowCount);
        } else {
            error_log("Failed to get all FAQs. No rows affected.");
        }
    
        return $faqs;
    }

    static public function addFaq($faq_question,$faq_answer) {
        global $db;

        $stmt = $db->prepare("INSERT INTO faq (question, answer) VALUES (:question, :answer)");
        $stmt->bindParam(':question',$faq_question);
        $stmt->bindParam(':answer',$faq_answer);


        $stmt->execute();
    }
}
?>