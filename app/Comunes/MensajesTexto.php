<?php
namespace App\Comunes;
use App\Comunes\Utilidades;

class MensajesTexto
{

    public static function send_http_request($apikey, $secret, $uri, $method, $data)
    {
        
        $pdw = hash_hmac('sha1', $method . "|" . $uri . "|" . $data, $secret);
        
        $options = array(
                'http' => array(
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                                "Authorization: Hmac " . base64_encode($apikey . ':' . $pdw),
                    'method' => $method,
                    'content' => $data
                )
        );

        $context = stream_context_create($options);
        
        return file_get_contents($uri, false, $context);
    }


    public static function enviarSMS($numero,$texto)
    {
        $apikey = Utilidades::obtenerParametro("2");
        $secret = Utilidades::obtenerParametro("3");
        $uri = Utilidades::obtenerParametro("4");
        $method = "POST";
        //$data = "";
        $data = json_encode(array(
                "name" => "Envio por api",
                "notification" => false,
                "email" => '',
                //"indicative" => "57",
                "receiver" => "57;" . $numero . ";" . $texto . "",
                "idSmsCategory" => 43,
                "datesend" => '',
                "datenow" => true,
                "timezone" => "-0500"
        ));
        
        $result = MensajesTexto::send_http_request($apikey, $secret, $uri, $method, $data, base64_encode($data) );

    }
    
}