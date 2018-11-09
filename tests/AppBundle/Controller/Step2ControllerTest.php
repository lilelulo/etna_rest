<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class Step2ControllerTest extends Step1ControllerTest
{
    public function test_2_all_domain_get() {
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('GET', '/api/domains.json');
        $this->checkFormatResponse($res, 200);
        foreach (array_slice($res['body']['datas'], 0, 5) as $domain) {
            $slug = $domain['slug'];
            $curl = new \AppBundle\Request\Curl($this->baseUrl);
            $res = $curl->send('GET', '/api/domains/'.$slug.'.json');
            $this->checkFormatResponse($res, 200);
            $domain = $res['body']['datas'];
            $this->assertObjectType($domain);
            $this->checkArray($domain, ['id', 'slug', 'name', 'description', 'creator', 'langs', 'created_at']);
            $this->checkArray($domain['creator'], ['id', 'username']);
            $this->assertSame($domain['slug'], $slug, sprintf("Le domaine recupéré pas le slug n'est pas le bon."));
        }
    }

    public function test_2_404_domain_get()
    {
        $rand = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $res = $curl->send('GET', '/api/domains/'.$rand.'.json');
        $this->checkFormatResponse($res, 404);
    }
}
