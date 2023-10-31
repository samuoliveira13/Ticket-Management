<?php
declare(strict_types = 1);
require_once(dirname(__DIR__).'/database/database.connection.php');
$db = getDatabaseConnection();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'UpdateTicket') {
    $ticket_id = $_POST['ticket_id'];
    $status = $_POST['status'];
    $department_name = $_POST['department_name'];
    
    Ticket::UpdateTicket(intval($ticket_id), $status, $department_name);
  }


  
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'RemoveTicketHashtag') {
    $ticket_id = $_POST['ticket_id'];
    $hashtag_id = $_POST['hashtag_id'];

    error_log('ticket_id: '.$ticket_id);
    error_log('hashtag_id: '.$hashtag_id);
    
    
    Ticket::RemoveTicketHashtag(intval($ticket_id),intval($hashtag_id));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'AddTicketHashtag') {
    $ticket_id = $_POST['ticket_id'];
    $hashtag_name = $_POST['hashtag_name'];

    error_log("AddTicketHashtag");
    error_log('ticket_id: '.$ticket_id);
    error_log('hashtag_name: '.$hashtag_name);
    
    $hashtag_id=Ticket::get_Hashtag_id($hashtag_name);
    
    Ticket::AddTicketHashtag(intval($ticket_id),intval($hashtag_id));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Hashtag_exists') {
    $hashtag_name = $_POST['hashtag_name'];

   
   
    
    $hashtag_id=Ticket::Hashtag_exists($hashtag_name);
    
    Ticket::Hashtag_exists($hashtag_name);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_new_Hashtag') {
  
    $hashtag_name = $_POST['hashtag_name'];

    Ticket::add_new_Hashtag($hashtag_name);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'addTicketChanges') {
  
    $ticket_id = $_POST['ticket_id'];
    $change_date = $_POST['change_date'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    $priority = $_POST['priority'];
    $assigned_to = $_POST['assigned_to'];
    $department_id = $_POST['department_id'];
    

    Ticket::AddTicketChanges($ticket_id, $change_date, $title, $description, $date, $status, $priority, $assigned_to, $department_id);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'getTicketforTicketChanges') {
  
    $ticket_id = $_POST['ticket_id'];
   
    

    Ticket::getTicketforTicketChanges(intval($ticket_id));
}

class Ticket{

    public int $ticket_id;
    public int $user_id;
    public string $title;
    public string $description;
    public datetime $date;
    public string $status;
    public string $priority;
    public int $assigned_to;
    public int $department_id;

    public static $Statuses = array('Open', 'Closed');
    public static $Priorities = array('Low', 'Medium', 'High');

    public function __construct(int $ticket_id, int $user_id, string $title, string $description, datetime $date , string $status, string $priority, int $assigned_to, int $department_id)
    {
        error_log("date time construct: ".$date->format('Y-m-d H:i:s'));
        $this->ticket_id=$ticket_id;
        $this->user_id=$user_id;
        $this->title=$title;
        $this->description=$description;
        $this->date=$date;
        $this->status=$status;
        $this->priority=$priority;
        $this->assigned_to=$assigned_to;
        $this->department_id=$department_id;
    }

    function getTicketId() {
        return $this->ticket_id;
    }
    function getUserId() {
        return $this->user_id;
    }
    function getTicketTitle() {
        return $this->title;
    }
    function getTicketDate() {
        return $this->date;
    }
    function getTicketStatus() {
        return $this->status;
    }
    function getTicketPriority() {
        return $this->priority;
    }
    function getAssigned_to(){
        return $this->assigned_to;
    }



    static function getTicket(PDO $db,int $id) : Ticket{

        $stmt = $db->prepare('SELECT * from tickets WHERE ticket_id = :id');
        
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $ticket = $stmt->fetch();

        return new Ticket(
            intval($ticket['ticket_id']),
            intval($ticket['user_id']),
            $ticket['title'],
            $ticket['description'],
            new \Datetime($ticket['date']),
            $ticket['status'],
            $ticket['priority'],
            intval($ticket['assigned_to']),
            intval($ticket['department_id'])
            );
    }

    static function getComments(PDO $db,int $id) : array{
        $stmt = $db->prepare('SELECT comment.description, comment.date, comment.ticket_id, users.name
        FROM comment
        JOIN users ON comment.user_id = users.id
        WHERE comment.ticket_id = :id
        ORDER BY comment.date DESC;
        
        ');
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $comments = $stmt->fetchAll();

        return $comments;
    }
    
    static function UpdateTicket(int $id,string $status,string $department_name){

        global $db;

        $department_id=Ticket::getDepartmentId($department_name);

        $stmt = $db->prepare('UPDATE tickets SET status = :status, department_id = :department_id WHERE ticket_id = :id');

      
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':department_id', $department_id);

  
        $stmt->execute();

      
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            error_log("Ticket updated successfully. Rows affected: " . $rowCount);
        } else {
            error_log("Failed to update ticket. No rows affected.");
        }

    }


    static public function getDepartmentId(string $name) : int {

        global $db;

        $stmt = $db->prepare('SELECT department_id FROM departments WHERE department_name = :department_name');
        $stmt->bindParam(':department_name', $name);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['department_id'];
    }

    public function getHashtags() :array {

        global $db;
        
        $stmt = $db->prepare('SELECT * FROM hashtags h INNER JOIN ticket_hashtags th ON h.hashtag_id = th.hashtag_id WHERE th.ticket_id = :ticket_id');
        $stmt->bindParam(':ticket_id', $this->ticket_id);
        
        $stmt->execute();
        $hashtags = $stmt->fetchAll();

        
        foreach($hashtags as $hashtag){
        error_log("hashtags no getHashtags:".print_r($hashtag,true));
        }
        return $hashtags;

    }

    static public function removeTicketHashtag(int $ticket_id, int $hashtag_id) {
        
        global $db;
  
        $stmt = $db->prepare("DELETE FROM ticket_hashtags WHERE ticket_id = :ticket_id AND hashtag_id = :hashtag_id");
    
        $stmt->bindParam(':ticket_id', $ticket_id);
        $stmt->bindParam(':hashtag_id', $hashtag_id);

        $stmt->execute();
   
        $rowCount = $stmt->rowCount();
    
        if ($rowCount > 0) {
            error_log("Hashtag was removed successfully. Rows affected: " . $rowCount);
        } else {
            error_log("Failed to delete hashtag. No rows affected.");
        }
    }

    static public function AddTicketHashtag(int $ticket_id,int $hashtag_id){
        global $db;

        $stmt = $db->prepare("INSERT INTO ticket_hashtags VALUES (:ticket_id,:hashtag_id)");
 
        $stmt->bindParam(':ticket_id', $ticket_id);
        $stmt->bindParam(':hashtag_id', $hashtag_id);
    

        $stmt->execute();

            
        $rowCount = $stmt->rowCount();
    
        if ($rowCount > 0) {
            error_log("Hashtag was added successfully. Rows affected: " . $rowCount);
        } else {
            error_log("Failed to add hashtag. No rows affected.");
        }
    }

    static public function getTickets(PDO $db, int $id) : array {
        $stmt = $db->prepare('SELECT tickets.*, departments.department_name FROM tickets JOIN departments ON tickets.department_id = departments.department_id WHERE user_id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $tickets = $stmt->fetchAll();

        return $tickets;
    }
    static public function getAssignedTickets(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT tickets.* FROM tickets where assigned_to = ?');
        $stmt->execute(array($id));

        $tickets = array();

        while($ticket = $stmt->fetch()) {
            $ticketObject = new Ticket (
                intval($ticket['ticket_id']),
                intval($ticket['user_id']),
                $ticket['title'],
                $ticket['description'],
                new \Datetime($ticket['date']),
                $ticket['status'],
                $ticket['priority'],
                intval($ticket['assigned_to']),
                intval($ticket['department_id'])
            );

            $tickets[] = $ticketObject; 
        }

        return $tickets;
    }
    static public function getUnassignedTickets(PDO $db) {
        $stmt = $db->prepare('SELECT tickets.* FROM tickets WHERE assigned_to IS NULL');
        $stmt->execute();

        $tickets = array();

        while($ticket = $stmt->fetch()) {
            $ticketObject = new Ticket (
                intval($ticket['ticket_id']),
                intval($ticket['user_id']),
                $ticket['title'],
                $ticket['description'],
                new \Datetime($ticket['date']),
                $ticket['status'],
                $ticket['priority'],
                intval($ticket['assigned_to']),
                intval($ticket['department_id'])
            );

        $tickets[] = $ticketObject; 
        }

        return $tickets;
    }

    static public function get_Hashtag_id(string $name) : int{
        global $db;
        
        $stmt=$db->prepare("SELECT hashtag_id FROM hashtags WHERE name = :name_hashtag");
        $stmt->bindParam(':name_hashtag', $name);
        
        $stmt->execute();
        $hashtag=$stmt->fetch();

        error_log("hastag no getHastgadid: ".$hashtag['hashtag_id']);
        
        return intval($hashtag['hashtag_id']);
    }

    static public function Hashtag_exists(string $hashtag_name){
        global $db;
        
        $stmt=$db->prepare("SELECT COUNT(*) FROM hashtags WHERE name = :hashtag_name");
        
        $stmt->bindParam(':hashtag_name', $hashtag_name);
        
        $stmt->execute();
        

        $rowCount = $stmt->fetchColumn();

        if ($rowCount > 0) {
      
            error_log("Hashtag exists. Rows affected: " . $rowCount);
            echo "true";
           
            } else {
            error_log("Hashtag doesnt exist. No rows affected.");
            echo "false";
         }
    }

    static public function add_new_Hashtag(string $hashtag_name){
        global $db;

        
        $stmt=$db->prepare("INSERT INTO hashtags (name) VALUES (:hashtag_name)");


        $stmt->bindParam(':hashtag_name', $hashtag_name);
        
        $stmt->execute();
        

    

        $rowCount = $stmt->rowCount();

        if ($rowCount > 0) {
            error_log("New Hashtag added. Rows affected: " . $rowCount);
            } else {
            error_log("Failed adding new hashtag. No rows affected.");
        }
    }

    static public function getAllTicketsAdmin(PDO $db) {
        $stmt = $db->prepare('SELECT tickets.* FROM tickets');
        $stmt->execute();

        $tickets = array();

        while($ticket = $stmt->fetch()) {
            $ticketObject = new Ticket (
                intval($ticket['ticket_id']),
                intval($ticket['user_id']),
                $ticket['title'],
                $ticket['description'],
                new \Datetime($ticket['date']),
                $ticket['status'],
                $ticket['priority'],
                intval($ticket['assigned_to']),
                intval($ticket['department_id'])
            );

            $tickets[] = $ticketObject; // Add the ticket object to the array
        }

        return $tickets;
    }

    static public function getTicketChanges($ticket_id) : array{
        global $db;

        $stmt = $db->prepare('SELECT tc.*, u.name AS assigned_to_name
        FROM ticket_change tc
        LEFT JOIN users u ON tc.assigned_to = u.id
        WHERE tc.ticket_id = :ticket_id');
        $stmt->bindParam(':ticket_id', $ticket_id);
        
        $stmt->execute();
        $ticket_changes = $stmt->fetchAll();

        return $ticket_changes;
    }

    static public function addTicketChanges($ticket_id, $change_date, $title, $description, $date, $status, $priority, $assigned_to, $department_id) {
        global $db;
    
        $stmt = $db->prepare('INSERT INTO ticket_change (ticket_id, change_date, title, description, date, status, priority, assigned_to, department_id)
                              VALUES (:ticket_id, :change_date, :title, :description, :date, :status, :priority, :assigned_to, :department_id)');
    
        $stmt->bindParam(':ticket_id', $ticket_id);
        $stmt->bindParam(':change_date', $change_date);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':priority', $priority);
        $stmt->bindParam(':assigned_to', $assigned_to);
        $stmt->bindParam(':department_id', $department_id);
    
        $stmt->execute();
    }

    static function getTicketforTicketChanges(int $id){

        global $db;

        $stmt = $db->prepare('SELECT * from tickets WHERE ticket_id = :id');
        
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $ticket = $stmt->fetch();

        echo json_encode($ticket);
    
    }


    static public function getDepartmentName(int $department_id) : string{

        global $db;

        $stmt = $db->prepare('SELECT department_name FROM departments WHERE department_id = :department_id');
        $stmt->bindParam(':department_id', $department_id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['department_name'];
    }
    
    
    

    
}
