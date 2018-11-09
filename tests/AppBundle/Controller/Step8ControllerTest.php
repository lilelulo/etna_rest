<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class Step8ControllerTest extends Step7ControllerTest
{
    public function test_8_200_get_domain_with_bad_account ()
    {

        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('GET', '/api/domains/mailer.json', [], ['Authorization: sqgsuyfgsjdhgfsdjkghf']);
        $this->checkHTTPcode($res, 200);
        $this->checkArray($res['body'], ['code', 'datas', 'message']);
        $domain = $res['body']['datas'];
        $this->checkArray($domain, ['id', 'slug', 'name', 'description', 'creator', 'langs', 'created_at']);
        $creator = $domain['creator'];
        $this->checkArray($creator, ['id', 'username']);
    }

    public function test_8_200_get_domain_with_good_account ()
    {

        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('GET', '/api/domains/mailer.json', [], ['Authorization: ezygazkfuygezkfjgzkefj']);
        $this->checkHTTPcode($res, 200);
        $this->checkArray($res['body'], ['code', 'datas', 'message']);

        $domain = $res['body']['datas'];
        $this->checkArray($domain, ['id', 'slug', 'name', 'description', 'creator', 'langs', 'created_at']);
        $creator = $domain['creator'];
        $this->checkArray($creator, ['id', 'username', 'email']);
    }
}