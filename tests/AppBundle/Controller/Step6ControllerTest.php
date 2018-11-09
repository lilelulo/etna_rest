<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class Step6ControllerTest extends Step5ControllerTest
{
    public function test_6_200_delete_domain_translation_without_auth ()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send(
            'POST', 
            '/api/domains/mailer/translations.json', 
            [
                'code' => '_'.$uniqid.'_', 
                'trans' => [
                    'FR' => $uniqid . ' - FR',
                    'EN' => $uniqid . ' - EN'
                ]
            ], 
            ['Authorization: ezygazkfuygezkfjgzkefj']
        );
        $trans = $res['body']['datas']['id'];

        $delete = $curl->send('DELETE', '/api/domains/mailer/translations/'.$trans.'.json');
        $this->assertSame($delete['status'], 401);
        $this->assertSame(count($delete['body']), 2);
        $this->assertArrayHasKey('code', $delete['body']);
        $this->assertArrayHasKey('message', $delete['body']);
    }

    public function test_6_200_delete_domain_translation_with_wrong_auth ()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send(
            'POST', 
            '/api/domains/mailer/translations.json', 
            [
                'code' => '_'.$uniqid.'_', 
                'trans' => [
                    'FR' => $uniqid . ' - FR',
                    'EN' => $uniqid . ' - EN'
                ]
            ], 
            ['Authorization: ezygazkfuygezkfjgzkefj']
        );
        $trans = $res['body']['datas']['id'];
        $delete = $curl->send('DELETE', '/api/domains/mailer/translations/'.$trans.'.json', [], ['Authorization: sqgsuyfgsjdhgfsdjkghf']);
        $this->assertSame($delete['status'], 403);
        $this->assertSame(count($delete['body']), 2);
        $this->assertArrayHasKey('code', $delete['body']);
        $this->assertArrayHasKey('message', $delete['body']);
    }

    public function test_6_200_delete_domain_translation_with_auth ()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send(
            'POST', 
            '/api/domains/mailer/translations.json', 
            [
                'code' => '_'.$uniqid.'_', 
                'trans' => [
                    'FR' => $uniqid . ' - FR',
                    'EN' => $uniqid . ' - EN'
                ]
            ], 
            ['Authorization: ezygazkfuygezkfjgzkefj']
        );
        $trans = $res['body']['datas']['id'];

        $delete = $curl->send('DELETE', '/api/domains/mailer/translations/'.$trans.'.json', [], ['Authorization: ezygazkfuygezkfjgzkefj']);
        $this->assertSame($delete['status'], 200);
        $this->assertSame(count($delete['body']), 3);
        $this->assertArrayHasKey('code', $delete['body']);
        $this->assertArrayHasKey('message', $delete['body']);

        $get = $curl->send('GET', '/api/domains/mailer/translations.json');
        $this->assertSame(array_search($delete['body']['datas'], array_column($get['body']['datas'], 'id')), false);
    }
}