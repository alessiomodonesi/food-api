<?php

require __DIR__ . "/base.php";
require __DIR__ . " /../COMMON/errorHandler.php";
set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class User extends BaseController
{
    public function getUser($id)
    {
        $sql = sprintf("SELECT name, surname, email, password
            FROM user
            WHERE id = %d;",
            $this->conn->real_escape_string($id));

        $result = $this->conn->query($sql);

        $this->SendOutput($result, JSON_OK);
    }

    public function deleteUser($id)
    {
        $sql = sprintf("UPDATE user 
            SET active = 0 
            WHERE id = %d",
            $this->conn->real_escape_string($id));

        $result = $this->conn->query($sql);
        return $result;
    }

    public function resetPassword($id)
    {
        $date = date("d:m:Y h:i:s");

        // Generazione della password randomica
        $password = bin2hex(openssl_random_pseudo_bytes(4));

        // Update password con password temporanea
        $sql = sprintf("UPDATE `user`
        SET password = '%s'
        where id = %d", 
        $this->conn->real_escape_string($password),
        $this->conn->real_escape_string($id));

        $result = $this->conn->query($sql);

        echo json_encode(["message" => $result]);

        if ($result == false) {
            http_response_code(503);
            echo json_encode(["message" => "Couldn't upload the password"]);
            return $result;
        }

        $sql = null;
        
        $sql = sprintf('SELECT email
        from `user`
        where id = %d',
        $this->conn->real_escape_string($id));

        $result  = $this->conn->query($sql);
        
        /*while($row = $result->fetch_assoc()){

            $this->sendEmail($row["email"], $password);
        }*/


        unset($sql);

        //Aggiunge alla tabella reset 
        $sql = sprintf("INSERT INTO reset
        (user, password, completed)
        VALUES (%d, '%s', 0)",
            $this->conn->real_escape_string($id),
            $this->conn->real_escape_string($password)        
        );
        //$this->conn->real_escape_string(date("d:m:Y h:i:s", strtotime($date . '+ 5 Days'))) sistemare

        $result = $this->conn->query($sql);
        echo json_encode(["message" => $result]);
        return $password;
    }

    public function login($email, $password)
    {
        $sql = sprintf("SELECT email, name , surname, password
        FROM `user`
        where 1=1 ");
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            if ($this->conn->real_escape_string($email) == $this->conn->real_escape_string($row["email"]) && $this->conn->real_escape_string($password) == $this->conn->real_escape_string($row["password"])) {

                return true;
            }
        }

        return false;
    }

    public function changePassword($email, $password, $newPassword)
    {
        if($this->login($email, $password) == false){
            return false;
        }
        
        $sql = sprintf("UPDATE user 
            SET password = '%s'
            WHERE email = '%s' AND password = '%s'",
            $this->conn->real_escape_string($newPassword),
            $this->conn->real_escape_string($email),
            $this->conn->real_escape_string($password)
        );

        $result = $this->conn->query($sql);

        return $result;
    }

    public function registration($name, $surname, $email, $password)
    {

        $sql = sprintf("INSERT INTO user (name , surname, email, password, active)
        VALUES ('%s', '%s', '%s', '%s', 1)",
            $this->conn->real_escape_string($name),
            $this->conn->real_escape_string($surname),
            $this->conn->real_escape_string($email),
            $this->conn->real_escape_string($password)
        );

        $result = $this->conn->query($sql);
        return $result;
    }

}