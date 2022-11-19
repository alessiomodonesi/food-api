<?php
class Controller
{
    public $conn;
    function __construct($connection)
    {
        $this->conn = $connection;
    }
    protected function sendOutput($data, $headers = array())
    {
        $this->SetHeaders($headers);

        $arr = array();
        while ($row = $data->fetch_assoc()) {
            array_push($arr, $row);
        }
        print_r(json_encode($arr, JSON_PRETTY_PRINT));
        exit;
    }
    public function sendError($headers = array())
    {
        $this->SetHeaders($headers);

        $err = "parametri non corretti";
        print_r(json_encode($err));
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