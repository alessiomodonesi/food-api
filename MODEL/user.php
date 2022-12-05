<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class User
{
    private Connect $db;
    private PDO $conn;

    public function __construct()
    {
        $this->db = new Connect;
        $this->conn = $this->db->getConnection();
    }

    public function getUser($id)
    {
        $sql = "SELECT name, surname, email
            FROM user
            WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id)
    {
        $sql = "UPDATE user 
            SET active = 0 
            WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function resetPassword($id)
    {
        $date = date("d:m:Y h:i:s");

        // Generazione della password randomica
        $password = bin2hex(openssl_random_pseudo_bytes(4));

        // Update password con password temporanea
        $sql = "UPDATE user
            SET password = :password
            WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        $stmt->execute();

        // Aggiunta alla tabella reset l'utente
        $sql = "INSERT INTO reset
            (user, password, requested, expires, completed)
            VALUES (:user, :password, :requested, :expires, :completed)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user', $id, PDO::PARAM_INT);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':requested', $date, PDO::PARAM_STR);
        $stmt->bindValue(':completed', date("d:m:Y h:i:s", strtotime($date . '+ 5 Days')), PDO::PARAM_STR);
        $stmt->bindValue(':completed', 0, PDO::PARAM_INT);

        $stmt->execute();

        return $password;
    }

    public function login($id, $email, $password)
    {
        $sql = "SELECT id
        FROM user 
        WHERE id = :id AND email = :email AND password = :password AND active = 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function changePassword($id, $email, $password, $newPassword)
    {
        if ($this->login($id, $email, $password) == 1) {
            $sql = "UPDATE user 
            SET password = :newPassword
            WHERE email = :email AND password = :password";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->bindValue(':newPassword', $newPassword, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->rowCount();
        }
    }
}
