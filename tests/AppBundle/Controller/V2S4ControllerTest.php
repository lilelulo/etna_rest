<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class V2S4ControllerTest extends V2S3ControllerTest
{
    public function test_4_post_domain_translation_noauth_noform()
    {
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res = $curl->send('POST', '/api/recipes.json', [], []);
        $this->checkFormatResponse($res, 401);
    }


    public function test_4_post_domain_translation_noauth_invalidform()
    {
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res = $curl->send('POST', '/api/recipes.json', [
            'name' => '', 
            'step' => []
        ]);
        $this->checkFormatResponse($res, 401);
    }

    public function test_4_post_domain_translation_noauth_validform()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res = $curl->send('POST', '/api/recipes.json', [
            'slug' => $uniqid,
            'name' => $uniqid,
            'step' => [uniqid(),uniqid(),uniqid()]
        ]);
        $this->checkFormatResponse($res, 401);
    }

    public function test_4_post_domain_translation_gooduserauth_invalidform_name()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res = $curl->send('POST', '/api/recipes.json', [
            'slug' => $uniqid,
            'step' => [uniqid(),uniqid(),uniqid()]
        ], ['Authorization: passworddelilelulo']);
        $this->checkFormatResponse($res, 400);
    }

    public function test_4_post_domains_translation_gooduserauth_validform()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res = $curl->send(
            'POST', 
            '/api/recipes.json', 
            [
                'slug' => $uniqid,
                'name' => $uniqid,
                'step' => [uniqid(),uniqid(),uniqid()]
            ], 
            ['Authorization: passworddelilelulo']
        );
//        dump($res);
        $this->checkFormatResponse($res, 201);
        $this->assertObjectType($res['body']['datas']);

        $recipe = $res['body']['datas'];
        $this->checkArray($recipe, ['id', 'slug', 'name', 'user', 'step']);
        $this->checkArray($recipe['user'], ['id', 'username', 'last_login']);

        $this->assertSame($uniqid, $recipe['name']);
        $this->assertSame($uniqid, $recipe['slug']);

        $res = $curl->send('GET', '/api/recipes.json');
        $filt = array_filter($res['body']['datas'], function($row) use ($recipe) {
            return $row['id'] == $recipe['id'];
        });
        $this->assertSame(count($filt), 1);
        $this->assertSame($filt[max(array_keys($filt))]['name'], $recipe['name']);
        $this->assertSame((int) $filt[max(array_keys($filt))]['id'], (int) $recipe['id']);
    }

    public function test_4_post_domains_translation_autogenerate_slug() {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res = $curl->send(
            'POST', 
            '/api/recipes.json', 
            [
                'name' => $uniqid,
                'step' => [uniqid(),uniqid(),uniqid()]
            ], 
            ['Authorization: passworddelilelulo']
        );
        $this->checkFormatResponse($res, 201);
    }

    public function test_4_post_domains_translation_dublicate_code()
    {

        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res = $curl->send(
            'POST', 
            '/api/recipes.json', 
            [
                'slug' => $uniqid,
                'name' => $uniqid,
                'step' => [uniqid(),uniqid(),uniqid()]
            ], 
            ['Authorization: passworddelilelulo']
        );
        $this->checkFormatResponse($res, 201);
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res = $curl->send(
            'POST', 
            '/api/recipes.json', 
            [
                'slug' => $uniqid,
                'name' => $uniqid,
                'step' => [uniqid(),uniqid(),uniqid()]
            ], 
            ['Authorization: passworddelilelulo']
        );
        $this->checkFormatResponse($res, 400);
    }
}
