<?php
    declare(strict_types=1);



    class User {
        public int $id;
        public string $name;
        public string $username;
        public string $email;
        public string $password;
        public string $role;
        public $department_id;

        public function __construct(int $id, string $name, string $username, string $email, string $password, string $role, $department_id) {
            if($department_id == null) $department_id = '0';

            $this->id = $id;
            $this->name = $name;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->role = $role;
            $this->department_id = $department_id;
        }
        
        public function setName(string $name) {
            $_SESSION['name'] = $name;
        }

        public function getName() : string {
            $names = explode(" ", $this->name);
            return count($names) > 1 ? $names[0]. " " . $names[count($names)-1] : $names[0];
        }

        public function setId(int $id) {
            $_SESSION['id'] = $id;
        }
        public function getId() : ?int {
            return isset($_SESSION['id']) ? $_SESSION['id'] : null;
        }

        public function setPassword(int $id) {
            $_SESSION['id'] = $id;
        }

        public function getDepartmentName(PDO $db){
            if($this->department_id === '0') return "Unassigned";

            $stmt = $db->prepare('SELECT department_name FROM departments WHERE department_id = :department_id');
            $stmt->bindParam(':department_id', $this->department_id);
            $stmt->execute();
        
            $department = $stmt->fetch();

            return $department['department_name'];
        }

        static function getUserWithPassword(PDO $db, string $username, string $password) :?User {
            $stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
            $stmt->execute(array(strtolower($username)));
            $user = $stmt->fetch();
            if ($user !== false && password_verify($password, $user['password'])) {
                return new User(
                    intval($user['id']),
                    $user['name'],
                    $user['username'],
                    $user['email'],
                    $user['password'],
                    $user['role'],
                    $user['department_id'],
                );
            } else return null;
        }

        static function getUsers(PDO $db) : array {
            $stmt = $db->prepare('SELECT id, name, username, email, password, role, department_id FROM users');
            $stmt->execute();

            $users = array();
            while($user = $stmt->fetch()) {
                $users[] = new User (
                    intval($user['id']),
                    $user['name'],
                    $user['username'],
                    $user['email'],
                    $user['password'],
                    $user['role'],
                    $user['department_id'],
                );
            }
            return $users;
        }

        static function getUser(PDO $db, int $id) : User {
            $stmt = $db->prepare('SELECT id, name, username, email, password, role, department_id FROM users WHERE id = ?');
            $stmt->execute(array($id));

            $user = $stmt->fetch();

            return new User (
                intval($user['id']),
                $user['name'],
                $user['username'],
                $user['email'],
                $user['password'],
                $user['role'],
                $user['department_id'],     
            );
        }
        
        public function changeRole(string $role){
            $this->role= $role;
        }

        static function getUser_name($db, int $id) :string {
            $stmt = $db->prepare('SELECT name FROM users WHERE id = :user_id');
            $stmt->bindParam(':user_id', $id);
            $stmt->execute();
        
            $user = $stmt->fetch();

            return $user['name'];
        }

        function save($db) {
            $stmt = $db->prepare('
              UPDATE users SET name = ?, username = ?, email = ?, password = ?
              WHERE id = ?
            ');
      
            $stmt->execute(array($this->name, $this->username, $this->email, $this->password,  $this->id));
        }

        function saveAdmin($db) {
            $stmt = $db->prepare('
                UPDATE users SET role = :role, department_id = :department_id
                WHERE id = :id
            ');
        
            try {
                $stmt->bindParam(':role', $this->role);
                $stmt->bindParam(':department_id', $this->department_id);
                $stmt->bindParam(':id', $this->id);            
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                error_log('Error: ' . $e->getMessage());
                return false;
            }
        }
        
        static function getAgents(PDO $db) : array {
            $stmt = $db->prepare('SELECT id, name, username, email, password, role, department_id FROM users WHERE role = "agent"');
            $stmt->execute();

            $users = array();
            while($user = $stmt->fetch()) {
                $users[] = new User (
                    intval($user['id']),
                    $user['name'],
                    $user['username'],
                    $user['email'],
                    $user['password'],
                    $user['role'],
                    $user['department_id'],
                );
            }
            return $users;
        }
        
    }
?>