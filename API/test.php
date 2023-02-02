<?php
require("../COMMON/connect.php");
require("../MODEL/base.php");

die();

class DBStructure extends BaseController
{
    public function SendOutputObj($data, $headers = array())
    {
        $this->SetHeaders($headers);
        print_r(json_encode($data, JSON_PRETTY_PRINT));
        exit;
    }
    public function GetTablesName($send) //mostra un singolo prodotto

    {
        $sql = "show tables;";
        $result = $this->conn->query($sql);

        $arr = array();
        while ($row = $result->fetch_assoc()) {
            $res = json_encode($row);
            $res = explode(":", $res)[0];
            $res = str_replace("\"", "", $res);
            $res = str_replace("{", "", $res);

            array_push($arr, $row[$res]);
        }

        if ($send) {
            $this->SendOutputObj($arr, JSON_OK);
            return;
        }
        return $arr;

    }
    public function GetTablesStructure() //mostra un singolo prodotto

    {
        $dbDescribe = null;
        $tablesName = $this->GetTablesName(false);

        for ($i = 0; $i < count($tablesName); $i++) {
            $sql = "DESCRIBE `" . $tablesName[$i] . "`;";
            $result = $this->conn->query($sql);

            $arr = array();
            while ($row = $result->fetch_assoc()) {
                $line["Field"] = $row["Field"];
                $line["Type"] = $row["Type"];
                array_push($arr, $line);
            }
            $dbDescribe[$tablesName[$i]] = $arr;
        }
        $this->SendOutputObj($dbDescribe, JSON_OK);
    }
    public function ChangeID() //mostra un singolo prodotto

    {
        //UPDATE `objects` SET `ID` = 'row_66' WHERE `objects`.`ID` = 'row_5';
        $sql = "select ID from objects;";
        $result = $this->conn->query($sql);


        $arr = array();
        while ($row = $result->fetch_assoc()) {
            array_push($arr, $row["ID"]);
        }
        //print_r(json_encode($arr, JSON_PRETTY_PRINT));

        for ($i = 0; $i < count($arr); $i++) {
            $sql = "UPDATE objects SET ID = '" . intval($arr[$i] - 10) . "' WHERE ID = '" . $arr[$i] . "';";
            //$result = $this->conn->query($sql);
            echo $sql . "</br>";
        }

        //$this->SendOutputObj($arr, JSON_OK);
    }

}

$database = new Database();
$db_connection = $database->connect();

$dbStruct = new DBStructure($db_connection);
?>