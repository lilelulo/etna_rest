<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class Step7ControllerTest extends Step6ControllerTest
{
    public function test_7_200_get_domain_translation_with_filter ()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $search = rand(1, 9);
        $res = $curl->send(
            'GET', 
            '/api/domains/mailer/translations.json?code='.$search
        );
        $this->checkHTTPcode($res, 200);
        $this->checkArray($res['body'], ['code', 'datas', 'message']);
        foreach ($res['body']['datas'] as $key => $value) {
            $pos = strpos($value['code'], (string) $search);
            $this->assertNotSame(false, $pos, sprintf('user [%s] filter [%s]', $value['code'], $search));
        }
    }
}