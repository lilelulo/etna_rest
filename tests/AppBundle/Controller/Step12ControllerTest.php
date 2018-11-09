<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class Step12ControllerTest extends Step11ControllerTest
{

    public function test_12_400_get_params_fail()
    {
        $uniqid = uniqid();
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
        $langs = $curl->send('FILE', '/api/domains/mailer/langs/EN.xliff');
        $this->checkHTTPcode($langs, 200);
        $xml = new \XMLReader();
        $this->assertSame(!$xml->xml($langs['body'], NULL, LIBXML_DTDVALID), false);
    }

    
}