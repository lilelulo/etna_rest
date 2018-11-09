<?php
namespace AppBundle\Request;

class Curl
{
	static $url;
	static $type;
    public function __construct($apiUrl, $header = array())
    {
        $this->apiUrl           = $apiUrl;
        $this->defaultHeader    = $header;
    }

    public function send($type, $url, $parameters = [], $headers = [])
	{
		$baseUrl = $this->apiUrl;

	    $headers = array_merge($headers, []);
	    $options = [
	        CURLOPT_HEADER => true,
	        CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 5
	    ];

	    $url = rtrim($this->apiUrl.$url, '/');
	    self::$url = $url;
	    self::$type = $type;
	    $options[CURLOPT_CUSTOMREQUEST] = $type;
	    $options[CURLOPT_HTTPHEADER] = $headers;

	    $ch = curl_init();
	    switch($type) {
	        case 'FILE':
	            $options[CURLOPT_CUSTOMREQUEST] = 'GET';
			    $options[CURLOPT_URL] = $url;
			    curl_setopt_array($ch, $options);
			    $response = curl_exec($ch);
			    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
			    curl_close($ch);
			    list($headers, $body) = explode("\r\n\r\n", $response, 2);
			    return array(
			        'body' => $body,
			        'headers' => $headers,
			        'status' => $status
			    );
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
	            $options[CURLOPT_POSTFIELDS] = http_build_query($parameters);
	            $options[CURLOPT_POST] = 1;
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
	    if (!$response) {
	        throw new \Exception('Le serveur ne reponds pas ['.$url.'].');
	    }
/*	    if (explode("\r\n\r\n", $response, 2) !== 2) {
	        throw new \Exception('La réponse n\'est pas du http ['.$url.'] ['.$type.'].');
	    }*/
	    $pars = explode("\r\n\r\n", $response, 2);
	    if (!isset($pars[1]))
	        throw new \Exception('No content ['.$url.'] ['.$type.'].');

	    $headers = $pars[0];
	    $body = $pars[1];

	    $body = json_decode($body, true);
		if (json_last_error ()) {
	        throw new \Exception('La réponse n\'est pas du json ['.$url.'] ['.$type.'].');
		}

	    if (isset($body->error)) {
	        throw new \Exception($url);
	    }

	    return array(
	        'body' => $body,
	        'headers' => $headers,
	        'status' => $status
	    );
	}
}
