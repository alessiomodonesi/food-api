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
}