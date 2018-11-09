<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class Step9ControllerTest extends Step8ControllerTest
{
    public function test_9_400_post_domains_with_auth_and_langfail()
    {
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send(
            'POST', 
            '/api/domains.json', 
            [
                'name' => uniqid(), 
                'description' => 'blabla',
                'lang' => [
                    uniqid(),
                    'EN'
                ]
            ], 
            ['Authorization: sqgsuyfgsjdhgfsdjkghf']
        );
        $this->checkHTTPcode($res, 400);
        $this->checkArray($res['body'], ['code', 'datas', 'message']);
    }

    public function test_9_400_post_domains_with_auth_and_namefail()
    {
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send(
            'POST', 
            '/api/domains.json', 
            [
                'name' => '',
                'description' => 'blabla',
                'lang' => [
                    'FR',
                    'EN'
                ]
            ], 
            ['Authorization: sqgsuyfgsjdhgfsdjkghf']
        );
        $this->checkHTTPcode($res, 400);
        $this->checkArray($res['body'], ['code', 'datas', 'message']);
    }


    public function test_9_400_post_domains_with_auth_and_noconect()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send(
            'POST', 
            '/api/domains.json', 
            [
                'name' => $uniqid,
                'description' => 'blabla',
                'lang' => [
                    'ES',
                    'IT'
                ]
            ]
        );
        $this->checkHTTPcode($res, 401);
        $this->checkArray($res['body'], ['code', 'message']);
    }

    public function test_9_400_post_domains_with_auth_and_noconect2()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send(
            'POST', 
            '/api/domains.json', 
            [
                'name' => $uniqid,
                'description' => 'blabla',
                'lang' => [
                    'ES',
                    'IT'
                ]
            ],
            ['Authorization: 11sqgsuyfgsjdhgfsdjkghf']
        );
        $this->checkHTTPcode($res, 401);
        $this->checkArray($res['body'], ['code', 'message']);
    }

    public function test_9_400_post_domains_with_auth_and_success()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send(
            'POST', 
            '/api/domains.json', 
            [
                'name' => $uniqid,
                'description' => 'blabla',
                'lang' => [
                    'ES',
                    'IT'
                ]
            ], 
            ['Authorization: sqgsuyfgsjdhgfsdjkghf']
        );

        $this->checkHTTPcode($res, 201);
        $this->checkArray($res['body'], ['code', 'datas', 'message']);
        $this->checkArray($res['body']['datas'], ['langs', 'id', 'slug', 'name', 'description', 'creator', 'created_at']);
        $this->checkArray($res['body']['datas']['creator'], ['id', 'username', 'email']);
        $this->assertSame($res['body']['datas']['creator']['id'], 2);
    }

    public function test_9_400_post_domains_with_auth_and_success_and_duplicate()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send(
            'POST', 
            '/api/domains.json', 
            [
                'name' => $uniqid,
                'description' => 'blabla',
                'lang' => [
                    'ES',
                    'IT'
                ]
            ], 
            ['Authorization: ezygazkfuygezkfjgzkefj']
        );
        $this->checkHTTPcode($res, 201);
        $resduplicate = $curl->send(
            'POST', 
            '/api/domains.json', 
            [
                'name' => $uniqid,
                'description' => 'blabla',
                'lang' => [
                    'ES',
                    'IT'
                ]
            ], 
            ['Authorization: sqgsuyfgsjdhgfsdjkghf']
        );
        $this->checkHTTPcode($resduplicate, 201);
        $this->assertNotSame($resduplicate['body']['datas']['slug'], $res['body']['datas']['slug']);
        $this->assertNotSame($resduplicate['body']['datas']['id'], $res['body']['datas']['id']);
    }

}