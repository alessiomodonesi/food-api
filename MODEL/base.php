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
    public function sendEmail($email, $password){
        $to = $email;
        $subject = 'Test reset passw';
        $message = '
        <html>
            <head>
             <title>Office supplies for March</title>
            </head>
            <body>
                <h1> La tua password temporanea e`:'.$password.'</h1>
            </body>
        </html>
        ';

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'From: WELA LA PASSWORD mattia.gallinaro@iisviolamarchiesini.edu.it';

        //$headers[] = 'From: Supply Reminders <reminders@example.com>';

        mail($to, $subject, $message, implode("\r\n", $headers));

    }
}