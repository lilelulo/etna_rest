<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class Step13ControllerTest extends Step12ControllerTest
{

    public function test_13_get_json()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
		$res = $curl->send('GET', '/api/domains');
        $this->checkHTTPcode($res, 200);
        $this->checkArray($res['body'], ['code', 'message', 'datas']);
		$resjson = $curl->send('GET', '/api/domains');
        $this->checkHTTPcode($resjson, 200);
        $this->checkArray($resjson['body'], ['code', 'message', 'datas']);

        $this->assertSame($resjson['headers'], $res['headers'], sprintf("L'utilisateur na pas les meme header"));
        $this->assertSame($resjson['body'], $res['body'], sprintf("L'utilisateur na pas les meme header"));

    }
    
}