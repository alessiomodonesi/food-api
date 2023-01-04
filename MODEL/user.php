<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPOffice\PHPOffice\PHPSpreadsheet;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/base.php";
require __DIR__ . " /../COMMON/errorHandler.php";
require __DIR__ . "/../vendor/phpmailer/phpmailer/src/PHPMailer.php";
require __DIR__ . "/../vendor/phpmailer/phpmailer/src/Exception.php";
require __DIR__ . "/../vendor/phpmailer/phpmailer/src/SMTP.php";

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class User extends BaseController
{
    public function getUser($id)
    {
        $sql = sprintf(
            "SELECT name, surname, email
            FROM user
            WHERE id = %d;",
            $this->conn->real_escape_string($id)
        );

        $result = $this->conn->query($sql);

        $this->SendOutput($result, JSON_OK);
    }

    protected function getUserFromEmail($email)
    {

        $sql = sprintf(
            "SELECT id
        FROM `user` 
        WHERE email = '%s' ",
            $this->conn->real_escape_string($email)
        );

        $result = $this->conn->query($sql);

        return $result;
    }

    public function getLastUserIdFromNameAndSur($name, $surname)
    {
        $sql = sprintf(
            "SELECT id
        FROM `user`
        ORDER BY id DESC
        WHERE name = '%s' and surname = '%s'
        LIMIT 1",
            $this->conn->real_escape_string($name),
            $this->conn->real_escape_string($surname)
        );

        $result = $this->conn->query($sql);
    }


    public function deleteUser($id)
    {
        $sql = sprintf(
            "UPDATE user 
            SET active = 0 
            WHERE id = %d",
            $this->conn->real_escape_string($id)
        );

        $result = $this->conn->query($sql);
        return $result;
    }

    public function ResetPassword($email)
    {
        $date = date("d:m:Y h:i:s");

        // Generazione della password randomica
        $password = bin2hex(openssl_random_pseudo_bytes(4));

        // Update password con password temporanea
        $sql = sprintf(
            "UPDATE `user`
        SET password = '%s'
        where email = '%s'",
            $this->conn->real_escape_string($password),
            $this->conn->real_escape_string($email)
        );

        $result = $this->conn->query($sql);

        //echo json_encode(["message" => $result]);

        if ($result == false) {
            http_response_code(503);
            echo json_encode(["message" => "Couldn't upload the password"]);
            return $result;
        }


        $this->SendEmail($email, $password);

        $result = null;

        $result = $this->getUserFromEmail($this->conn->real_escape_string($email));

        unset($sql);

        while ($row = $result->fetch_assoc()) {
            //Aggiunge alla tabella reset 
            $sql = sprintf(
                "INSERT INTO reset
                (user, password, completed)
                VALUES ('%s', '%s', 0)",
                $this->conn->real_escape_string($row['id']),
                $this->conn->real_escape_string($password)
            );
            //$this->conn->real_escape_string(date("d:m:Y h:i:s", strtotime($date . '+ 5 Days'))) sistemare
        }
        return $password;
    }

    public function login($email, $password)
    {
        $sql = sprintf("SELECT email, password, id
        FROM `user`
        where 1=1 ");
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            if ($this->conn->real_escape_string($email) == $this->conn->real_escape_string($row["email"]) && $this->conn->real_escape_string($password) == $this->conn->real_escape_string($row["password"])) {
                return $this->conn->real_escape_string($row["id"]);
            }
        }

        return false;
    }

    public function changePassword($email, $password, $newPassword)
    {
        if ($this->login($email, $password) == false) {
            return false;
        }

        $sql = sprintf(
            "UPDATE user 
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

        $sql = sprintf(
            "INSERT INTO user (name , surname, email, password, active)
        VALUES ('%s', '%s', '%s', '%s', 1)",
            $this->conn->real_escape_string($name),
            $this->conn->real_escape_string($surname),
            $this->conn->real_escape_string($email),
            $this->conn->real_escape_string($password)
        );

        $result = $this->conn->query($sql);
        return $result;
    }

    public function SendEmail($email, $password)
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "sandwech.amministrazione.test@gmail.com";
        $mail->Password = "jnupkpmzolyfmcpf";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom("sandwech.amministrazione.test@gmail.com");
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Prova PHPMailSender";
        $mail->Body = "ecco la password : " . $password . "";

        if (!$mail->send()) {
            /*
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            */
            return $mail->ErrorInfo;
        } else {
            //echo 'Message has been sent';
            return true;
        }
    }
    public function createTablePersons()
    {

        $sql = sprintf("CREATE TABLE IF NOT EXISTS sandwiches.person (
            name VARCHAR(64),
            surname VARCHAR(64),
            class VARCHAR(5),
            section VARCHAR(5)
            );");

        $result = $this->conn->query($sql);

        if ($result) {
            echo "Table created";
        } else {
            echo "Already there";
        }

        unset($sql);

        $sql = sprintf("TRUNCATE `person`");
        $this->conn->query($sql);
    }

    public function insert_Table($person)
    {
        $sql = sprintf(
            "INSERT INTO person (name, surname, class, section)
        VALUES('%s', '%s', '%s', '%s')",
            $this->conn->real_escape_string($person[0]),
            $this->conn->real_escape_string($person[1]),
            $this->conn->real_escape_string($person[2]),
            $this->conn->real_escape_string($person[3])
        );

        $this->conn->query($sql);
    }

    public function getUserFromTable()
    {
        $sql = sprintf("SELECT *
        FROM `user`
        WHERE 1=1");

        $result = $this->conn->query($sql);

        return $result;
    }
    public function insert_User($name, $surname)
    {
        $sql = sprintf(
            "INSERT INTO `user` (name, surname, active)
        VALUES('%s', '%s' , false)",
            $this->conn->real_escape_string($name),
            $this->conn->real_escape_string($surname)
        );

        $result = $this->conn->query($sql);
    }
}
