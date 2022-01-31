<?php

header('Content-Type: text/html; charset=utf-8');

function getSSL($domain_name)
{
    $errno = 0;
    $errstr = '';
    
    $timeout = 30;

    $ssl_info = stream_context_create(array(
                                        "ssl" => array(
                                        "capture_peer_cert" => TRUE)));

    $stream = stream_socket_client("ssl://" . $domain_name . ":443", 
                                    $errno, 
                                    $errstr, 
                                    $timeout, 
                                    STREAM_CLIENT_CONNECT, 
                                    $ssl_info);

    if (!$stream) {
        echo "ERROR: $errno - $errstr";
    } else {
        $cert_resource = stream_context_get_params($stream);
        $certificate = $cert_resource['options']['ssl']['peer_certificate'];
        $certinfo = openssl_x509_parse($certificate);
        fclose($stream);
        return $certinfo;
    }
}

$certinfo = getSSL("sielsi.ru");

echo '<div style="margin: 0 auto; width: 50%;"><h1 style="color: #00f;">Данные о сертификате SIELSI:</h1><hr>';

echo "<pre style='color: #a9a9a9;'>";
print_r($certinfo);
echo "</pre>";

echo '<hr><p style="text-align: center;"><a href="https://letsencrypt.org/" target="_blank">&copy; Let`s Encrypt</a></p></div>';

?>
