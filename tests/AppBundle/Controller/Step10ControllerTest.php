<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class Step10ControllerTest extends Step9ControllerTest
{
    public function test_10_400_post_domains_with_auth_and_success()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $domain = $curl->send(
            'POST', 
            '/api/domains.json', 
            [
                'name' => $uniqid,
                'description' => 'blabla',
                'lang' => [
                    'ES',
                    'IT',
                    'FR'
                ]
            ], 
            ['Authorization: sqgsuyfgsjdhgfsdjkghf']
        );
        $this->checkHTTPcode($domain, 201);
        $uniqid = uniqid();
        $translation = $curl->send(
            'POST', 
            '/api/domains/'.$domain['body']['datas']['slug'].'/translations.json', 
            [
                'code' => '_'.$uniqid.'_', 
                'trans' => [
                    'ES' => $uniqid . ' - ES',
                    'IT' => $uniqid . ' - IT'
                ]
            ], 
            ['Authorization: sqgsuyfgsjdhgfsdjkghf']
        );
        $this->checkHTTPcode($translation, 201);
        $res = $curl->send('DELETE', '/api/domains/'.$domain['body']['datas']['slug'].'/langs/ES.json', [], ['Authorization: sqgsuyfgsjdhgfsdjkghf']);
        $this->checkHTTPcode($res, 200);
        $domain = $curl->send('GET', '/api/domains/'.$domain['body']['datas']['slug'].'.json');
        $this->checkHTTPcode($domain, 200);
        $this->assertSame(count($domain['body']['datas']['langs']), 2, sprintf('La lang n est pas delete dans le domain'));


        $translations = $curl->send('GET', '/api/domains/'.$domain['body']['datas']['slug'].'/translations.json');
        $this->checkHTTPcode($translations, 200);
        foreach ($translations['body']['datas'] as $value) {
            $this->assertSame(count($value['trans']), 2, sprintf('La lang n est pas delete dans la translations '. '/api/domains/'.$domain['body']['datas']['slug'].'/translations.json'));
        }
    }
}