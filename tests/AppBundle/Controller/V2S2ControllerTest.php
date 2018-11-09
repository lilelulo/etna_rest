<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class V2S2ControllerTest extends V2S1ControllerTest
{
    public function test_2_all_recipes_get() {
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res = $curl->send('GET', '/api/recipes.json');
        $this->checkFormatResponse($res, 200);
        foreach (array_slice($res['body']['datas'], 0, 5) as $recipe) {
            $slug = $recipe['slug'];
            $curl = new \AppBundle\Request\Curl($this->baseUrl());
            $res = $curl->send('GET', '/api/recipes/'.$slug.'.json');
            $this->checkFormatResponse($res, 200);
            $recipe = $res['body']['datas'];
            $this->assertObjectType($recipe);
            $this->checkArray($recipe, ['id', 'slug', 'name', 'user']);
            $this->checkArray($recipe['user'], ['id', 'username', 'last_login']);
            $this->assertSame($recipe['slug'], $slug, sprintf("Le domaine recupéré pas le slug n'est pas le bon."));
        }
    }

    public function test_2_404_domain_get()
    {
        $rand = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl());
        $res = $curl->send('GET', '/api/recipes/'.$rand.'.json');
        $this->checkFormatResponse($res, 404);
    }
}
