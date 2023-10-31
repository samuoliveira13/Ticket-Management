<?php
    declare(strict_types=1);
    
    class Session {
        private array $messages;

        public function __construct() {
            session_start();

            $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
            unset($_SESSION['messages']);

            if (!isset($_SESSION['csrf'])) {
                $_SESSION['csrf'] = bin2hex(random_bytes(16));
            }
        }

        public function isLoggedIn() : bool {
            return isset($_SESSION['id']);
        }

        public function logout() {
            session_destroy();
        }

        public function addMessage(string $type, string $text) {
            $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
        }

        public function getMessages() {
            return $this->messages;
        }

        public function getId() : ?int {
            return isset($_SESSION['id']) ? $_SESSION['id'] : null;    
        }
    }
?>