<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class Step4ControllerTest extends Step3ControllerTest
{
    public function test_4_post_domain_translation_noauth_noform()
    {
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('POST', '/api/domains/mailer/translations.json');
        $this->checkFormatResponse($res, 401);
    }

    public function test_4_post_domain_translation_badauth_noform()
    {
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('POST', '/api/domains/mailer/translations.json', [], ['Authorization: nocheck']);
        $this->checkFormatResponse($res, 401);
    }

    public function test_4_post_domain_translation_baduserauth_noform()
    {
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('POST', '/api/domains/mailer/translations.json', [], ['Authorization: sqgsuyfgsjdhgfsdjkghf']);
        $this->checkFormatResponse($res, 403);
    }

    public function test_4_post_domain_translation_baduserauth_invalidform()
    {
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('POST', '/api/domains/mailer/translations.json', [
            'code' => '', 
            'trans' => [
                'EN' => uniqid() . ' - EN'
            ]
        ], ['Authorization: sqgsuyfgsjdhgfsdjkghf']);
        $this->checkFormatResponse($res, 403);
    }

    public function test_4_post_domain_translation_noauth_invalidform()
    {
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('POST', '/api/domains/mailer/translations.json', [
            'code' => '', 
            'trans' => [
                'EN' => uniqid() . ' - EN'
            ]
        ]);
        $this->checkFormatResponse($res, 401);
    }

    public function test_4_post_domain_translation_baduserauth_validform()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('POST', '/api/domains/mailer/translations.json', [
            'code' => '_'.$uniqid.'_', 
            'trans' => [
                'FR' => $uniqid . ' - FR',
                'EN' => $uniqid . ' - EN'
            ]
        ], ['Authorization: sqgsuyfgsjdhgfsdjkghf']);
        $this->checkFormatResponse($res, 403);
    }

    public function test_4_post_domain_translation_noauth_validform()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('POST', '/api/domains/mailer/translations.json', [
            'code' => '_'.$uniqid.'_', 
            'trans' => [
                'FR' => $uniqid . ' - FR',
                'EN' => $uniqid . ' - EN'
            ]
        ]);
        $this->checkFormatResponse($res, 401);
    }

    public function test_4_post_domain_translation_gooduserauth_invalidform_code()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('POST', '/api/domains/mailer/translations.json', [
            'code' => '', 
            'trans' => [
                'FR' => $uniqid . ' - FR',
                'EN' => $uniqid . ' - EN'
            ]
        ], ['Authorization: ezygazkfuygezkfjgzkefj']);
        $this->checkFormatResponse($res, 400);
    }

    public function test_4_post_domain_translation_gooduserauth_invalidform_lang()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('POST', '/api/domains/mailer/translations.json', [
            'code' => $uniqid, 
            'trans' => [
                $uniqid => $uniqid . ' - FR',
                'EN' => $uniqid . ' - EN'
            ]
        ], ['Authorization: ezygazkfuygezkfjgzkefj']);
        $this->checkFormatResponse($res, 400);
    }

    public function test_4_post_domains_translation_gooduserauth_validform()
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

        $this->checkFormatResponse($res, 201);
        $this->assertObjectType($res['body']['datas']);

        $trans = $res['body']['datas'];
        $this->assertSame(count($trans), 3);
        $this->assertArrayHasKey('id', $trans);
        $this->assertArrayHasKey('code', $trans);
        $this->assertArrayHasKey('trans', $trans);
        $this->assertArrayHasKey('PL', $trans['trans'], 'Vous n avez pas renvoyé la valide du la lang PL par defaut');
        $this->assertSame('_'.$uniqid.'_', $trans['trans']['PL']);
        $this->assertSame('_'.$uniqid.'_', $trans['code']);

        $res = $curl->send('GET', '/api/domains/mailer/translations.json');
        $filt = array_filter($res['body']['datas'], function($row) use ($trans) {
            return $row['id'] == $trans['id'];
        });
        $this->assertSame(count($filt), 1);
        $this->assertSame($filt[max(array_keys($filt))]['code'], $trans['code']);
        $this->assertSame($filt[max(array_keys($filt))]['id'], $trans['id']);
    }

    public function test_4_post_domains_translation_dublicate_code()
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
        $this->checkFormatResponse($res, 201);
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
        $this->checkFormatResponse($res, 400);
    }
}
