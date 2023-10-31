<?php
declare(strict_types = 1);

class Ticket{

    public int $ticket_id;
    public int $user_id;
    public string $title;
    public string $description;
    public string $status;
    public string $priority;
    public int $department_id;

    public function __construct(int $ticket_id, int $user_id, string $title, string $description, string $status, string $priority, int $department_id)
    {
        $this->ticket_id=$ticket_id;
        $this->user_id=$user_id;
        $this->title=$title;
        $this->description=$description;
        $this->status=$status;
        $this->priority=$priority;
        $this->department_id=$department_id;
    }

    static function getTicket(PDO $db,int $id) : Ticket{
        $stmt = $db->prepare('SELECT * FROM tickets WHERE id = :id');
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $ticket = $stmt->fetch();
        
        return new Ticket(
            $ticket['ticket_id'],
            $ticket['user_id'],
            $ticket['title'],
            $ticket['description,'],
            $ticket['status'],
            $ticket['priority'],
            $ticket['department_id']
        );
    }

}
