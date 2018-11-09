<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{

    /**
     * @Template("default/test.html.twig")
     * @Route("/testing", name="testing")
     */
    public function testAction(Request $request)
    {
        $form = $this->createForm("AppBundle\Form\ApiTesterType", [], ['csrf_protection' => false, 'method' => 'POST']);
        $form->handleRequest($request, false);
        $status = -1;
        if ($form->isValid()) {
            $datas = $form->getData();
            try {
                file_put_contents(
                    '/home/lilelulo/projects/etna_rest_crowding/phpunit.xml.dist', 
                    str_replace(
                        '__SERVER__',
                        $datas['baseUrl'],
                        file_get_contents('/home/lilelulo/projects/etna_rest_crowding/phpunit.xml.tpl')
                    )
                );
                putenv('LANG=en_US.UTF-8'); 
                exec(
                    sprintf(
                        'php /home/lilelulo/projects/etna_rest_crowding/vendor/bin/simple-phpunit -c /home/lilelulo/projects/etna_rest_crowding/phpunit.xml.dist --filter %s',
                        $datas['sort']
                    ), 
                    $output, 
                    $status);
                $result = 
                str_replace(
                    ['[30;42m', '', '[31;1mE', '[37;41m', '[0m'],
                    ['<span style="background-color:green">', ' ', '<span style="background-color:green">', '<span style="background-color:red">', '</span>'],
                    implode('<br/>',$output)
                );
                error_log($result);
            } catch (\Exception $e){
                $result = 'Gros erreur sur l outil de test contacte le prof';
            }
        }
        return [
            'form' => $form->createView(),
            'result' => $result ?? 'Appuyez sur le boutton tester pour avoir un resultat.',
            'status' => $status
        ];
    }

    /**
     * @Route("/{slug}", name="donation.oldhomepage", requirements={"slug" = ".*.[^json]$"})
     */
    public function indexAction(Request $request, $slug)
    {
        $response = new JsonResponse([
            "code"=> 400,
            "message"=> 'Bad request',
            "datas"=> [
                'authorized format' => ['json']
            ]
        ]);
        $response->setStatusCode(400);
        return $response;
    }
}
