<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class V2S5ControllerTest extends V2S4ControllerTest
{
    public function test_5_put_basic_ok()
    {
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

        $resput = $curl->send(
            'PUT', 
            '/api/recipes/'.$res['body']['datas']['slug'].'.json', 
            [
                'name' => $uniqid."-1",
            ],
            ['Authorization: passworddelilelulo']
        );
        $this->assertSame($resput['status'], 200);
    }
    public function test_5_put_basic_ok_and_updated()
    {
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

        $resput = $curl->send(
            'PUT', 
            '/api/recipes/'.$res['body']['datas']['slug'].'.json', 
            [
                'name' => $uniqid."-1",
            ],
            ['Authorization: passworddelilelulo']
        );
        $this->assertSame($resput['status'], 200);
        $recipe = $res['body']['datas'];
        $resGet = $curl->send('GET', '/api/recipes.json');
        $filt = array_filter($resGet['body']['datas'], function($row) use ($recipe) {
            return $row['id'] == $recipe['id'];
        });
        $this->assertSame(count($filt), 1);
        $this->assertSame($filt[max(array_keys($filt))]['name'], $uniqid."-1");
    }
    public function test_5_put_unauthorize()
    {
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

        $resput = $curl->send(
            'PUT', 
            '/api/recipes/'.$res['body']['datas']['slug'].'.json', 
            [
                'name' => $uniqid."-1",
            ],
            ['Authorization: passworddeetna']
        );
        $this->assertSame($resput['status'], 403);
    }
    public function test_5_put_unauthorize_unform()
    {
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

        $resput = $curl->send(
            'PUT', 
            '/api/recipes/'.$res['body']['datas']['slug'].'.json', 
            [
                'name' => '',
            ],
            ['Authorization: passworddeetna']
        );
        $this->assertSame($resput['status'], 403);
    }
    public function test_5_put_unform()
    {
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

        $resput = $curl->send(
            'PUT', 
            '/api/recipes/'.$res['body']['datas']['slug'].'.json', 
            [
                'name' => '',
            ],
            ['Authorization: passworddelilelulo']
        );
        $this->assertSame($resput['status'], 400);
    }
    public function test_5_put_error_slug()
    {
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
        $uniqid1 = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res1 = $curl->send(
            'POST', 
            '/api/recipes.json', 
            [
                'name' => $uniqid1,
                'step' => [uniqid(),uniqid(),uniqid()]
            ], 
            ['Authorization: passworddelilelulo']
        );
        $this->checkFormatResponse($res1, 201);
        $resput = $curl->send(
            'PUT', 
            '/api/recipes/'.$res['body']['datas']['slug'].'.json', 
            [
                'slug' => $res1['body']['datas']['slug'],
            ],
            ['Authorization: passworddelilelulo']
        );
        $this->assertSame($resput['status'], 400);
    }
}
