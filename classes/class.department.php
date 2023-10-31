<?php
    declare(strict_types=1);

    class Department {

        public int $department_id;
        public string $name;

        public function __construct(int $department_id, string $name) {
            $this->department_id = $department_id;
            $this->name = $name;
        }

        static function getDepartments(PDO $db) : array {
            $stmt = $db->prepare('SELECT department_id, department_name FROM departments');
            $stmt->execute();
        
            $departments = $stmt->fetchAll();
        
            return $departments;
        }

        static function getDepartmentIdByName(PDO $db, string $dName): int {
            $stmt = $db->prepare('SELECT department_id FROM departments WHERE department_name = :name');
            $stmt->bindParam(':name', $dName);
            $stmt->execute();

            $id = $stmt->fetch();

            return (int)$id['department_id'];
        }


        static function getDepartment(PDO $db, int $id) : Department {
            $stmt = $db->prepare('SELECT department_id, department_name FROM departments WHERE department_id = ?');
            $stmt->execute(array($id));

            $user = $stmt->fetch();

            return new Department (
                intval($user['department_id']),
                $user['department_name']
            );
        }

        static public function getDepartmentName(PDO $db, int $ticket_id) {
            $stmt = $db->prepare('SELECT d.department_name FROM departments d 
            INNER JOIN tickets t ON t.department_id = d.department_id WHERE t.ticket_id = :ticket_id');
            $stmt->bindParam(':ticket_id', $ticket_id);
            $stmt->execute();

            $department = $stmt->fetch();

            return $department['department_name'];
        }

        static public function getDepartmentByUsername(PDO $db, int $user_id) {
            $stmt = $db->prepare('SELECT d.department_name FROM departments d 
            INNER JOIN users u ON u.department_id = d.department_id WHERE u.id = :user_id');
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();

            $department = $stmt->fetch();

            return $department['department_name'];
        }

    }


?>