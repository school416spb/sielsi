<?php

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
echo "<pre style='color: #00f;'>";
print_r($certinfo);
echo "</pre>";

?>