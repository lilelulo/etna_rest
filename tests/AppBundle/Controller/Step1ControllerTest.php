<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class Step1ControllerTest extends TestCase
{
    public $baseUrl = 'http://172.16.237.75';
//    public $baseUrl = 'http://192.168.109.129:8886';

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
    	$curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('GET', '/api/domains.json');
        $this->checkFormatResponse($res, 200);
        $this->assertInternalType('array', $res['body']['datas']);

        $indice = array_rand($res['body']['datas']);
        $domain = $res['body']['datas'][$indice];
        $this->checkArray($domain, ['id', 'slug', 'name', 'description']);
    }

    public function test_1_404_response() {
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('GET', '/api/'.uniqid().'.json');
        $this->checkFormatResponse($res, 404);
    }

    public function test_1_400_response() {
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('GET', '/api/domains.dd');
        $this->checkFormatResponse($res, 400);
    }
}
