<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class Step11ControllerTest extends Step10ControllerTest
{

    public function test_11_400_get_params_fail()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $langs = $curl->send('GET', '/api/langs.json?per_page2');
        $this->checkHTTPcode($langs, 200);
    }

    public function test_11_400_get_params_fail1()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $langs = $curl->send('GET', '/api/langs.json?per_page=2&page=-1');
        $this->checkHTTPcode($langs, 400);
    }


    public function test_11_400_get_params_fail2()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $langs = $curl->send('GET', '/api/langs.json?per_page=2&page=page');
        $this->checkHTTPcode($langs, 400);
    }

    public function test_11_400_post_domains_with_auth_and_success()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $langs = $curl->send('GET', '/api/langs.json?per_page=2&page=1');

        $this->checkHTTPcode($langs, 200);
        $this->assertSame(count($langs['body']['datas']), 2, sprintf('Le nombre langue n est pas bon on attends %s, il en a %s', 2, count($langs['body']['datas'])));
        $langs2 = $curl->send('GET', '/api/langs.json?per_page=2&page=2');
        $this->assertNotSame(
            implode(',', $langs['body']['datas']),
            implode(',', $langs2['body']['datas']),
            'le resultat des langs est le meme'
        );
    }
}