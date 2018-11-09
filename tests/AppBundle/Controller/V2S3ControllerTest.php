<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class V2S3ControllerTest extends V2S2ControllerTest
{
    public function test_3_200_domains_translations_get()
    {
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res = $curl->send('GET', '/api/recipes.json');
        $this->checkFormatResponse($res, 200);
        foreach (array_slice($res['body']['datas'], 0, 5) as $recipe) {
            $slug = $recipe['slug'];
            $curl = new \AppBundle\Request\Curl($this->baseUrl());
            $res = $curl->send('GET', '/api/recipes/'.$slug.'/steps.json');
            $this->checkFormatResponse($res, 200);
            $steps = $res['body']['datas'];
            $this->assertInternalType('array', $steps);
        }
    }

    public function test_3_404_recipe_steps_get()
    {
        $rand = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res = $curl->send('GET', '/api/recipes/'.$rand.'/steps.json');
        $this->checkFormatResponse($res, 404);
    }
}
