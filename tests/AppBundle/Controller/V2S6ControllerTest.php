<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class V2S6ControllerTest extends V2S5ControllerTest
{
    public function test_6_200_delete_basic_ok ()
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
            'DELETE', 
            '/api/recipes/'.$res['body']['datas']['slug'].'.json', 
            [],
            ['Authorization: passworddelilelulo']
        );
        $this->assertSame($resput['status'], 200);
    }

    public function test_6_200_delete_basic_401 ()
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
            'DELETE', 
            '/api/recipes/'.$res['body']['datas']['slug'].'.json', 
            [],
            ['Authorization: azd']
        );
        $this->assertSame($resput['status'], 401);

    }

    public function test_6_200_delete_basic_403 ()
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
            'DELETE', 
            '/api/recipes/'.$res['body']['datas']['slug'].'.json', 
            [],
            ['Authorization: passworddeetna']
        );
        $this->assertSame($resput['status'], 403);

    }
}