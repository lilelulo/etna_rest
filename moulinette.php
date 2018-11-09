<?php

function send($type, $url, $parameters = [], $headers = [])
{
	$baseUrl = 'http://192.168.109.129:8888/app_dev.php';
    $headers = array_merge($headers, []);
    $options = [
        CURLOPT_HEADER => true,
        CURLOPT_RETURNTRANSFER => true
    ];

    $url = rtrim($baseUrl.$url, '/');
    $options[CURLOPT_CUSTOMREQUEST] = $type;
    $options[CURLOPT_HTTPHEADER] = $headers;

    $ch = curl_init();
    switch($type) {
        case 'POST':
            $options[CURLOPT_CUSTOMREQUEST] = 'POST';
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = http_build_query($parameters);
            break;
        case 'DELETE':
            $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
            break;
        case 'GET':
            $options[CURLOPT_CUSTOMREQUEST] = 'GET';
            break;
        case 'PUT':
            $options[CURLOPT_CUSTOMREQUEST] = 'PUT';
            break;
        default:
        	throw new \Exception("CURL type not defined", 1);
            break;
    }

    $options[CURLOPT_URL] = $url;
    curl_setopt_array($ch, $options);

    $response = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    list($headers, $body) = explode("\r\n\r\n", $response, 2);

    $body = json_decode($body, true);

    if (isset($body->error)) {
        throw new \Exception($url);
    }

    return array(
        'body' => $body,
        'headers' => $headers,
        'status' => $status
    );
}

$res = send('GET', '/api/domains.json');
if ($res['status'])
var_dump($res);