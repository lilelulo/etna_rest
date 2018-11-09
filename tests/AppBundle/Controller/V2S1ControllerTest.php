<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class V2S1ControllerTest extends TestCase
{
//    public $baseUrl = 'http://51.38.35.243';
//    public $baseUrl = 'http://192.168.109.129:8886';

    public function baseUrl() {
        return $_ENV['SERVER_IP'];
    }

    protected function checkArray($res, $filters) 
    {
        $this->assertSame(
            count($res), 
            count($filters), 
            sprintf(
                "INVALID KEY\nUSER [%s] [%s] \nSUCCESS [%s] [%s]",
                count($res),
                implode(',', array_keys($res)),
                count($filters),
                implode(',', $filters)
            )
        );
        foreach ($filters as $value) {
            $this->assertArrayHasKey(
                $value, 
                $res, 
                sprintf('La clé %s n\'existe pas dans l\'objet [%s]', $value, json_encode($res))
            );
        }
    }

    protected function checkHTTPcode($res, $code) 
    {
        $this->assertSame(
            $res['status'], 
            $code, 
            sprintf(
                "[%s] [%s] - [%s] HTTP code invalid [SUCCESS => %s]",
                \AppBundle\Request\Curl::$type,
                \AppBundle\Request\Curl::$url,
                $res['status'], 
                $code
            )
        );
    }

    protected function checkFormatResponse($response, $code) 
    {
        $this->checkHTTPcode($response, $code);
        if ($code == 404 || $code == 403 || $code == 401)
            $this->checkArray($response['body'], ['code', 'message']);
        else 
            $this->checkArray($response['body'], ['code', 'message', 'datas']);
        switch ($code) {
            case 200:
                $this->assertSame(
                    strtolower($response['body']['message']),
                    strtolower('OK'), 
                    sprintf(
                        "invalid message [%s] => %s",
                        $response['body']['message'],
                        \AppBundle\Request\Curl::$url
                    )
                );
                break;            
            case 201:
                $this->assertSame(
                    strtolower($response['body']['message']),
                    strtolower('Created'), 
                    sprintf(
                        "invalid message [%s] => %s",
                        $response['body']['message'],
                        \AppBundle\Request\Curl::$url
                    )
                );
                break;            
            case 401:
                $this->assertSame(
                    strtolower($response['body']['message']),
                    strtolower('Unauthorized'), 
                    sprintf(
                        "invalid message [%s] => %s",
                        $response['body']['message'],
                        \AppBundle\Request\Curl::$url
                    )
                );
                break;            
            case 404:
                $this->assertSame(
                    strtolower($response['body']['message']),
                    strtolower('Not Found'), 
                    sprintf(
                        "invalid message [%s] => %s",
                        $response['body']['message'],
                        \AppBundle\Request\Curl::$url
                    )
                );
                break;            
            case 403:
                $this->assertSame(
                    strtolower($response['body']['message']),
                    strtolower('Forbidden'), 
                    sprintf(
                        "invalid message [%s] => %s",
                        $response['body']['message'],
                        \AppBundle\Request\Curl::$url
                    )
                );
                break;            
            case 400:
                $this->assertSame(
                    strtolower($response['body']['message']),
                    strtolower('Bad Request'), 
                    sprintf(
                        "invalid message [%s] => %s",
                        $response['body']['message'],
                        \AppBundle\Request\Curl::$url
                    )
                );
                break;            
            default:
                # code...
                break;
        }
        $this->assertSame(
            $response['body']['code'],
            $code, 
            sprintf(
                "[%s] - [%s] JSON code invalid [SUCCESS => %s]",
                \AppBundle\Request\Curl::$url,
                $response['status'], 
                $code
            )
        );
    }

    protected function is_assoc($var)
    {
        if (count($var) == 0)
            return true;
        return is_array($var) && array_diff_key($var,array_keys(array_keys($var)));
    }

    protected function assertObjectType($res) {
        $this->assertSame(true, $this->is_assoc($res), "La valeur n'est pas un object. [".json_encode($res)."]");
    }


	public function test_1_200_domains()
    {        
    	$curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res = $curl->send('GET', '/api/recipes.json');
        $this->checkFormatResponse($res, 200);
        $this->assertInternalType('array', $res['body']['datas']);

        $indice = array_rand($res['body']['datas']);
        $domain = $res['body']['datas'][$indice];
        $this->checkArray($domain, ['id', 'slug', 'name']);
    }

    public function test_1_404_response() {
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res = $curl->send('GET', '/api/'.uniqid().'.json');
        $this->checkFormatResponse($res, 404);
    }
}
