<?php

    class UserDTO {
        private PDO $conn;

        public function __construct(PDO $conn) {
            $this->conn = $conn;
        }

        public function getAll() {
            $sql = 'SELECT * FROM s5project.users';
            $res = $this->conn->query($sql, PDO::FETCH_ASSOC);
    
            if($res) { // Controllo se ci sono dei dati nella variabile $res
                return $res;
            }

            return null;
        }
        public function getUserByID(int $id) {
            $sql = 'SELECT * FROM s5project.users WHERE id = :id';
            $stm = $this->conn->prepare($sql);
            $res = $stm->execute(['id' => $id]);
    
            if($res) { // Controllo se ci sono dei dati nella variabile $res
                return $res;
            }

            return null;
        }

        public function getUserByEmail(string $email) {
            $sql = 'SELECT * FROM s5project.users WHERE email = :email';
            $stm = $this->conn->prepare($sql);
            $res = $stm->execute(['email' => $email]);
    
            if($res) { // Controllo se ci sono dei dati nella variabile $res
                return $stm->fetchAll();
            }

            return null;
        }

        public function saveUser(array $user) {
            $sql = "INSERT INTO s5project.users (name, lastname, email, password) VALUES (:nome, :cognome, :mail, :pass)";
            $stm = $this->conn->prepare($sql);
            $stm->execute(['nome' => $user['name'], 'cognome' => $user['lastname'], 'mail' => $user['email'], 'pass' => $user['password']]);
            return $stm->rowCount();
        }
        public function updateUser(array $user) {
            $sql = "UPDATE s5project.users SET name = :nome, lastname = :cognome, email = :mail, password= :pass WHERE id = :id";
            $stm = $this->conn->prepare($sql);
            $stm->execute(['nome' => $user['name'], 'cognome' => $user['lastname'], 'mail' => $user['email'], 'pass' => $user['password'], 'id' => $user['id']]);
            return $stm->rowCount();
        }
        public function deleteUser(int $id) {
            $sql = "DELETE FROM s5project.users WHERE id = :id";
            $stm = $this->conn->prepare($sql);
            $stm->execute(['id' => $id]);
           return $stm->rowCount();
        }
    }