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
            "SELECT id, name, surname, email
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

    public function GetUserFromCredentials($name, $surname)
    {

        $sql = sprintf(
            "SELECT id
            FROM `user` 
            WHERE name = '%s' and surname = '%s' and active = 1;",
            $this->conn->real_escape_string($name),
            $this->conn->real_escape_string($surname)
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
        where active = 1 ");
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

        return $this->conn->insert_id;
    }

    public function addClass($year, $section)
    {
        $sql = sprintf(
            "INSERT INTO class (year, section)
            VALUES(%d , '%s')",
            $this->conn->real_escape_string($year),
            $this->conn->real_escape_string($section)
        );

        $result = $this->conn->query($sql);
        return $result;
    }
    public function getUserClass()
    {
        $year = date('Y');
        //if(date('m') < 9){
        //    $year -= 1;
        //}
        $sql = sprintf(
            "SELECT *
        FROM user_class uc
        INNER JOIN `user` u on u.id = uc.`user`
        INNER JOIN class c on c.id =  uc.class 
        WHERE  uc.`year` = %d
        ORDER BY uc.`year` DESC",
            $this->conn->real_escape_string($year)
        );

        $result = $this->conn->query($sql);
        return $result;
    }

    public function getActiveUsers()
    {
        $sql = sprintf("SELECT id, email, name , surname 
        FROM `user` 
        WHERE active = 1");
        $result = $this->conn->query($sql);
        return $result;
    }

    public function getSingleClass($class, $section)
    {
        $sql = sprintf(
            "SELECT id
        FROM class
        WHERE year = %d AND section = '%s'",
            $this->conn->real_escape_string($class),
            $this->conn->real_escape_string($section)
        );
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }
    public function addClassUser($id, $class)
    {
        $year = date('Y');
        $sql = sprintf(
            "INSERT INTO user_class (`user`, class, year)
            VALUES(%d, %d, %d)",
            $this->conn->real_escape_string($id),
            $this->conn->real_escape_string($class),
            $this->conn->real_escape_string($year)
        );
        $result = $this->conn->query($sql);
        return $result;
    }

    public function UpdateClassUser($studID, $classID)
    {
        $sql = sprintf(
            "SELECT class
            FROM user_class uc
            WHERE uc.`user` = %d;",
            $this->conn->real_escape_string($studID)
        );
        $result = $this->conn->query($sql);
        $classeStudente = array();
        while ($row = $result->fetch_assoc()) {
            array_push($classeStudente, $row);
        }

        if (($classeStudente == array()) == false) {
            if ($classID == $classeStudente[0]["class"]) {
                return -1;
            }
        }


        $year = date('Y');
        $sql = sprintf(
            "UPDATE user_class
            SET class = %d, year = %d
            WHERE `user` = %d;",
            $this->conn->real_escape_string($classID),
            $this->conn->real_escape_string($year),
            $this->conn->real_escape_string($studID)
        );
        $result = $this->conn->query($sql);
        return $result;
    }

    public function GetArchieveClass()
    {
        $sql = "SELECT *
                FROM class
                WHERE 1=1;";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function removeClassUser($user, $class)
    {
        $sql = sprintf(
            "DELETE FROM user_class WHERE `user` = %d AND class = %d",
            $this->conn->real_escape_string($user),
            $this->conn->real_escape_string($class)
        );
        $result = $this->conn->query($sql);
        return $result;
    }

    public function importUser($name, $surname, $email)
    {
        $sql = sprintf(
            "INSERT INTO `user` (name,surname,email,password,active)
              value('%s', '%s' ,'%s', '', 1);",
            $this->conn->real_escape_string($name),
            $this->conn->real_escape_string($surname),
            $this->conn->real_escape_string($email)
        );

        $result = $this->conn->query($sql);
        return $result;
    }

    public function updateUser($id, $name, $surname, $email, $passwd, $active)
    {
        $sql = sprintf(
            "UPDATE `user`
              set name= '%s' ,surname='%s',email='%s',password='%s', active= %d
              where id= %d;",
            $this->conn->real_escape_string($name),
            $this->conn->real_escape_string($surname),
            $this->conn->real_escape_string($email),
            $this->conn->real_escape_string($passwd),
            $this->conn->real_escape_string($active),
            $this->conn->real_escape_string($id)
        );

        $result = $this->conn->query($sql);

        return $result;
    }

    public function getUsers()
    {
        $sql = "SELECT * 
                FROM `user`
                WHERE active=1";

        $result = $this->conn->query($sql);
        return $result;
    }

    protected function GetTotalUsers()
    {
        $sql = "SELECT * 
                FROM `user`
                WHERE 1=1";

        $result = $this->conn->query($sql);
        return $result;
    }

    public function disactiveUser($id)
    {
        $sql = "UPDATE `user`
                SET active=0
                WHERE id=" . $id . ";";

        $result = $this->conn->query($sql);
        return $result;
    }
    public function getArchiveUser()
    {
        $sql = "SELECT *
        FROM `user` u
        WHERE 1=1;";

        $result = $this->conn->query($sql);
        return $result;
    }


    public function importOrderUser($userID, $section, $year)
    {
        $idclass = $this->getSingleClass($year, $section)->fetch_assoc();

        $sql = sprintf(
            "INSERT INTO user_class(`user`,class)
           value  (%d,%d);",
            $this->conn->real_escape_string($userID),
            $this->conn->real_escape_string($idclass["id"])
        );

        $result = $this->conn->query($sql);
    }


    public function updateOrderUser($userID, $section, $year)
    {
        $idclass = $this->getSingleClass($year, $section)->fetch_assoc();

        $sql = sprintf(
            "UPDATE user_class 
           set class=%d
           where id=%d;",
            $this->conn->real_escape_string($idclass["id"]),
            $this->conn->real_escape_string($userID)
        );

        $result = $this->conn->query($sql);
    }

    public function convertToHash()
    {

        $sql = "SELECT id, password 
        FROM `user` 
        WHERE 1=1";

        $result = $this->conn->query($sql);
        $query_sql = null;
        while ($row = $result->fetch_assoc()) {
            if ($row['password'] == "" or $row['password'] == null) {
                continue;
            }
            $query_sql = sprintf(
                "UPDATE `user` 
            SET password = '%s'
            WHERE id = %d",
                $this->conn->real_escape_string(hash('sha256', $row['password'])),
                $this->conn->real_escape_string($row['id'])
            );
            $final = $this->conn->query($query_sql);
            unset($query_sql);
        }
    }

    public function createColumnCounter()
    {

        $sql = "ALTER TABLE `user` ADD COLUMN counter INT NOT NULL DEFAULT 0";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function checkCounterEmail($email)
    {
        $sql = sprintf("SELECT id , counter from `user` WHERE email LIKE '%s' and active = 1", $this->conn->real_escape_string($email));
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return $user;
        } else {
            return -1;
        }
    }
    public function increaseCounter($id)
    {
        $sql = sprintf("UPDATE `user` SET counter = counter + 1 WHERE id = %d", $this->conn->real_escape_string($id));

        $this->conn->query($sql);
    }

    public function resetCounter($id)
    {
        $sql = sprintf("UPDATE `user` SET counter = 0 WHERE id = %d ", $this->conn->real_escape_string($id));

        $this->conn->query($sql);
    }

    public function activateUser($id)
    {
        $sql = sprintf("UPDATE `user` SET active = 1 WHERE id = %d", $this->conn->real_escape_string($id));

        $result = $this->conn->query($sql);
        return $result;
    }

    //public function 
    public function registration_Secure($name, $surname, $email, $password, $class, $year)
    {
        $sql = sprintf(
            "UPDATE `user` u
        inner join user_class uc on uc.`user` = u.id 
        inner join class c on c.id =  uc.class 
        set u.email = '%s',
        u.password = '%s'
        where uc.`year` = 2023 and c.year = %d and c.section = '%s' and u.name =  '%s' and u.surname = '%s';
        ",
            $this->conn->real_escape_string($password),
            $this->conn->real_escape_string($email),
            $this->conn->real_escape_string($year),
            $this->conn->real_escape_string($class),
            $this->conn->real_escape_string($name)
        );

        $result = $this->conn->query($sql);
        return $result;
    }
}