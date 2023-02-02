<?php

define(
    'JSON_OK',
    array(
        'Content-Type: application/json',
        'HTTP/1.1 200 OK'
    )
);

class BaseController
{
    public $conn;
    function __construct($connection)
    {
        $this->conn = $connection;
    }

    //Mostra contenuto json come jsonencode passandogli le informazioni che si vogliono vedere
    protected function SendOutput($data, $headers = array())
    {
        $this->SetHeaders($headers);

        $arr = array();
        while ($row = $data->fetch_assoc()) {
            array_push($arr, $row);
        }
        print_r(json_encode($arr, JSON_PRETTY_PRINT));
        exit;
    }
    public function SendError($headers = array())
    {
        $this->SetHeaders($headers);

        $err = "incorrect_parameters";
        print_r(json_encode($err));
        exit;
    }
    public function SendState($state, $headers = array())
    {
        $this->SetHeaders($headers);

        print_r(json_encode($state));
        exit;
    }
    protected function SetHeaders($httpHeaders = array())
    {
        header_remove('Set-Cookie');
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
    }
    public function StudentAlreadyExists($array, $obj)
    {
        //echo "Studente da controllare: " . $obj->nome . " " . $obj->cognome . " Grandezza array: " . count($array) . "\n";
        if (count($array) == 0) {
            return false;
        }
        for ($i = 0; $i < count($array); $i++) {
            if (
                    $array[$i]->nome == $obj->nome
                && $array[$i]->cognome == $obj->cognome
                && $array[$i]->classe == $obj->classe
                && $array[$i]->sezione == $obj->sezione
                && $array[$i]->indirizzo_studi == $obj->indirizzo_studi
                && $array[$i]->email == $obj->email
                && $array[$i]->anno == $obj->anno
            ) {
                return true;
            }
        }
        return false;
        /*
        [nome] => NOME STUDENTE
        [cognome] => COGNOME STUDENTE
        [classe] => 5E ITIS - ITIA - INFORMATICA
        [sezione] => E
        [indirizzo_studi] => INFORMATICA
        [email] => EMAIL STUDENTE
        [anno] => 5
        */
    }
}