<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class V2S8ControllerTest extends V2S7ControllerTest
{
    public function test_8_200_get_user_basic_ok ()
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

        $resg = $curl->send(
            'GET', 
            '/api/recipes/'.$res['body']['datas']['slug'].'.json', 
            [], 
            ['Authorization: passworddelilelulo']
        );
        $this->checkFormatResponse($resg, 200);
        $recipe = $resg['body']['datas'];
        $this->assertObjectType($recipe);
        $this->checkArray($recipe, ['id', 'slug', 'name', 'user']);
        $this->checkArray($recipe['user'], ['id', 'username', 'last_login', 'email']);
    }

    public function test_8_200_get_user_basic_without_auth ()
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
        $resg = $curl->send(
            'GET', 
            '/api/recipes/'.$res['body']['datas']['slug'].'.json', 
            [], 
            []
        );
        $this->checkFormatResponse($resg, 200);
        $recipe = $resg['body']['datas'];
        $this->assertObjectType($recipe);
        $this->checkArray($recipe, ['id', 'slug', 'name', 'user']);
        $this->checkArray($recipe['user'], ['id', 'username', 'last_login']);
    }

    public function test_8_200_get_user_other_auth ()
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

        $resg = $curl->send(
            'GET', 
            '/api/recipes/'.$res['body']['datas']['slug'].'.json', 
            [], 
            ['Authorization: passworddeetna']
        );
        $this->checkFormatResponse($resg, 200);
        $recipe = $resg['body']['datas'];
        $this->assertObjectType($recipe);
        $this->checkArray($recipe, ['id', 'slug', 'name', 'user']);
        $this->checkArray($recipe['user'], ['id', 'username', 'last_login']);
    }

    public function test_8_200_get_user_bad_auth ()
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

        $resg = $curl->send(
            'GET', 
            '/api/recipes/'.$res['body']['datas']['slug'].'.json', 
            [], 
            ['Authorization: passwozeafazefrddeetna']
        );
        $this->checkFormatResponse($resg, 200);
        $recipe = $resg['body']['datas'];
        $this->assertObjectType($recipe);
        $this->checkArray($recipe, ['id', 'slug', 'name', 'user']);
        $this->checkArray($recipe['user'], ['id', 'username', 'last_login']);
    }

}