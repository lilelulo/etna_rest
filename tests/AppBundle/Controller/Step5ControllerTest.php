<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class Step5ControllerTest extends Step4ControllerTest
{
    public function test_5_put_domains_translation_noauth()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $respost = $curl->send(
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
        $this->checkFormatResponse($respost, 201);
        $resput = $curl->send(
            'PUT', 
            '/api/domains/mailer/translations/'.$respost['body']['datas']['id'].'.json', 
            [
                'trans' => [
                    'FR' => $uniqid . ' - FR - 2',
                    'PL' => $uniqid . ' - PL'
                ]
            ]
        );
        $this->assertSame($resput['status'], 401);
    }

    public function test_5_put_domains_translation_badauth()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $respost = $curl->send(
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
        $this->checkFormatResponse($respost, 201);
        $resput = $curl->send(
            'PUT', 
            '/api/domains/mailer/translations/'.$respost['body']['datas']['id'].'.json', 
            [
                'trans' => [
                    'FR' => $uniqid . ' - FR - 2',
                    'PL' => $uniqid . ' - PL'
                ]
            ],
            ['Authorization: sqgsuyfgsjdhgfsdjkghf']
        );
        $this->assertSame($resput['status'], 403);
    }



    public function test_5_put_domains_translation_goodauth_validform()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $respost = $curl->send(
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
        $this->checkFormatResponse($respost, 201);
        $uniqid = uniqid();
        $resput = $curl->send(
            'PUT', 
            '/api/domains/mailer/translations/'.$respost['body']['datas']['id'].'.json', 
            [
                'trans' => [
                    'FR' => $uniqid . ' - FR - 2',
                    'PL' => $uniqid . ' - PL'
                ]
            ], 
            ['Authorization: ezygazkfuygezkfjgzkefj']
        );
        $this->checkFormatResponse($resput, 200);
        $this->assertSame($respost['body']['datas']['id'], $resput['body']['datas']['id']);
        $this->assertSame($respost['body']['datas']['code'], $resput['body']['datas']['code'], 'Le code a été modifie, sans aucune raison');
        $this->assertSame($uniqid . ' - FR - 2', $resput['body']['datas']['trans']['FR']);
        $this->assertSame($respost['body']['datas']['trans']['EN'], $resput['body']['datas']['trans']['EN']);
        $this->assertSame($uniqid . ' - PL', $resput['body']['datas']['trans']['PL']);
    }

    public function test_5_put_domains_translation_goodauth_invalidform_lang()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $respost = $curl->send(
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
        $this->checkFormatResponse($respost, 201);
        $resput = $curl->send(
            'PUT', 
            '/api/domains/mailer/translations/'.$respost['body']['datas']['id'].'.json', 
            [
                'trans' => [
                    $uniqid => uniqid() . ' - FR - 2',
                    'PL' => uniqid() . ' - PL'
                ]
            ], 
            ['Authorization: ezygazkfuygezkfjgzkefj']
        );
        $this->checkFormatResponse($resput, 400);
    }

}
