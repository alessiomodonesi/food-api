<?php


require __DIR__ . "/base.php";
require __DIR__ . " /../COMMON/errorHandler.php";
set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class User extends BaseController
{
    public function getUser($id)
    {
        $sql = "SELECT name, surname, email, password
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
        $sql = sprintf("UPDATE user
        SET password = '%s'
        where id = $id", $this->conn->real_escape_string($password));

        $result = $this->conn->query($sql);

        if($result == false){
            http_response_code(503);
            echo json_encode(["message" => "Couldn't upload the password"]);
            return $result;
        }
        unset($sql);

        // Aggiunta alla tabella reset l'utente
        /*$sql = "INSERT INTO reset
            (user, password, requested, expires, completed)
            VALUES (:user, :password, :requested, :expires, :completed)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user', $id, PDO::PARAM_INT);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':requested', $date, PDO::PARAM_STR);
        $stmt->bindValue(':completed', date("d:m:Y h:i:s", strtotime($date . '+ 5 Days')), PDO::PARAM_STR);
        $stmt->bindValue(':completed', 0, PDO::PARAM_INT);

        $stmt->execute();*/

        $sql = sprintf("INSERT INTO reset
        (user, password, requested, completed)
        VALUES (%i, %s, %s, 0)",
        $this->conn->real_escape_string($id),
        $this->conn->real_escape_string($password),
        $this->conn->real_escape_string($date));
        //$this->conn->real_escape_string(date("d:m:Y h:i:s", strtotime($date . '+ 5 Days'))) sistemare

        $result = $this->conn->query($sql);
        return $password;
    }

    public function login($email, $password)
    {
        $sql = sprintf("SELECT *
        FROM `user` 
        WHERE email = '%s' and password = '%s'", 
        $this->conn->real_escape_string($email), 
        $this->conn->real_escape_string($password));
        $result = $this->conn->query($sql);
        //echo json_encode(["message" => $result]); con il login corretto mi ritorna nulla
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

        $sql = sprintf("INSERT INTO user (name , surname, email, password, active)
        VALUES ('%s', '%s', '%s', '%s', 1)",
        $this->conn->real_escape_string($name),
        $this->conn->real_escape_string($surname),
        $this->conn->real_escape_string($email),
        $this->conn->real_escape_string($password));

        $result = $this->conn->query($sql);
        return $result;
    }
}
