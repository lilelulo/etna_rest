<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class V2S7ControllerTest extends V2S6ControllerTest
{
    public function test_7_200_get_domain_translation_with_filter ()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $search = rand(1, 9);
        $res = $curl->send(
            'GET', 
            '/api/recipes.json?name='.$search
        );
        $this->checkHTTPcode($res, 200);
        $this->checkArray($res['body'], ['code', 'datas', 'message']);
        if (count($res['body']['datas']) == 0) {
            throw new \Exception("pas de valeur filtre", 1);
        }
        foreach ($res['body']['datas'] as $key => $value) {
            $pos = strpos($value['name'], (string) $search);
            $this->assertNotSame(false, $pos, sprintf('user [%s] filter [%s]', $value['name'], $search));
        }
    }
}