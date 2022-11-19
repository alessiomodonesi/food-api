<?php
class Controller
{
    public $conn;
    function __construct($connection)
    {
        $this->conn = $connection;
    }

    protected function sendOutput($data, $httpHeaders = array())
    {
        header_remove('Set-Cookie');
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        $arr = array();
        while ($row = $data->fetch_assoc()) {
            array_push($arr, $row);
        }
        print_r(json_encode($arr, JSON_PRETTY_PRINT));
        exit;
    }
}
?>