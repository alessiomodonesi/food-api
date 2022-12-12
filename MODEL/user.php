<?php


require __DIR__ . "/base.php";
require __DIR__ . " /../COMMON/errorHandler.php";
set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class User extends BaseController
{
    public function getUser($id)
    {
        $sql = "SELECT name, surname, email
            FROM user
            WHERE id = " . $id . ";";

        $result = $this->conn->query($sql);

        $this->SendOutput($result, JSON_OK);
    }

    public function deleteUser($id)
    {
        $sql = "UPDATE user 
            SET active = 0 
            WHERE id = ".$id."";

        $result = $this->conn->query($sql);
        return $result;
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
        $sql = sprintf("SELECT *
        FROM `user` 
        WHERE id = $id and email = '%s' and password = '%s'", 
        $this->conn->real_escape_string($email), 
        $this->conn->real_escape_string($password));
        echo json_encode(["message" => $sql]);
        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }

    public function changePassword($id, $email, $password, $newPassword)
    {
        
            $sql = "UPDATE user 
            SET password = ?
            WHERE email = ? AND password = ?";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('sss', $password, $email, $newPassword);
            $stmt->execute();

            $result = $stmt->get_result();
        echo json_encode(["message" => $result]);
        return $stmt->num_rows;
    }

    public function registration($name, $surname, $email, $password){

        $sql = "INSERT INTO user (name , surname, email, password, active)
        VALUES (:name, :surname, :email, :password, 1) 
        ";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':surname', $surname, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->num_rows;
    }
}
