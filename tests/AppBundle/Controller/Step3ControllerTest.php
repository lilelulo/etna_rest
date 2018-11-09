<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class Step3ControllerTest extends Step2ControllerTest
{
	public function test_3_200_domains_translations_get()
    {
        $curl = new \AppBundle\Request\Curl($this->baseUrl);
		$res = $curl->send('GET', '/api/domains/mailer/translations.json');
        $this->checkFormatResponse($res, 200);
        $this->assertInternalType('array', $res['body']['datas']);
        foreach ($res['body']['datas'] as $domain) {
            $this->checkArray($domain, ['id', 'trans', 'code']);
            $this->assertObjectType($domain['trans']);
            $this->checkArray($domain['trans'], ['EN', 'PL', 'FR']);
        }
    }
}
