<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DomainController extends FOSRestController
{
    public function getDomainsAction()
    {
        $recipes = $this->get('doctrine')->getRepository("AppBundle:Crowding\Domain")->findAll();

        $data = array(
            "code" => 200,
            "message" => "success",
            "datas" => $recipes
        );
        $view = $this->view($data, 200);
        $context = new Context();
        $context->setGroups(['LIST']);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @ParamConverter("domain", class="AppBundle:Crowding\Domain", options={"repository_method" = "findOneBySlug"})
     */
    public function getDomainAction($domain)
    {
        $data = array(
            "code" => 200,
            "message" => "success",
            "datas" => $domain
        );
        $view = $this->view($data, 200);
        $context = new Context();
        $context->setGroups(['LIST', 'DETAIL']);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @ParamConverter("domain", class="AppBundle:Crowding\Domain", options={"repository_method" = "findOneBySlug"})
     */
    public function getDomainTranslationsAction(Request $request, $domain)
    {
        $search = $request->get('code', false);
        $data = array(
            "code" => 200,
            "message" => "success",
            "datas" => ($search !== false ? array_filter($domain->getTranslations()->toArray(), function ($row) use ($search) {
                return strpos($row->getCode(), $search) !== false;
            }) : $domain->getTranslations())
        );
        $view = $this->view($data, 200);
        $context = new Context();
        $context->setGroups(['LIST', 'DETAIL']);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @ParamConverter("domain", class="AppBundle:Crowding\Domain", options={"repository_method" = "findOneBySlug"})
     * @Security("has_role('ROLE_USER') && domain.getUser() == user")
     */
    public function postDomainTranslationsAction(Request $request, $domain)
    {
        $form = $this->createForm("AppBundle\Form\DomainTranslationType", [], ['csrf_protection' => false, 'method' => 'POST']);
        $form->handleRequest($request, false);
        if ($form->isValid()) {
            $datas = $form->getData();
            $trans = new \AppBundle\Entity\Crowding\Translation;
            $trans
                ->setDomain($domain)
                ->setCode($datas['code'])
            ;
            foreach ($datas['trans'] as $key => $value) {
                if (array_search($key, $domain->getVirtualLangs()) === false)
                    throw new \Exception("Lang not accepted", 400);
                $lang = new \AppBundle\Entity\Crowding\TranslationToLang;
                $lang
                    ->setLang($this->get('doctrine')->getRepository('AppBundle\Entity\Crowding\Lang')->find($key))
                    ->setTrans($value)
                    ->setTranslation($trans)
                ;
                $trans->addTranslationToLang($lang);
            }
            try {
                $this->get('doctrine')->getManager()->persist($trans);
                $this->get('doctrine')->getManager()->flush();
            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                throw new \Exception("Duplication du code dans le domain", 400);
            } catch (\Exception $e) {
                throw new \Exception("Une erreur est survenu recommence", 400);
            }

            $data = array(
                "code" => 201,
                "message" => "success",
                "datas" => $trans
            );
            $view = $this->view($data, 201);
            $context = new Context();
            $context->setGroups(['LIST', 'DETAIL']);
            $view->setContext($context);
            return $this->handleView($view);
        }
        $view = $this->view([
            'code'      => 400,
            'message'   => 'Bad request',
            'datas' => $form
        ], 400);
        return $this->handleView($view);
    }

    /**
     * @ParamConverter("domain", class="AppBundle:Crowding\Domain", options={"repository_method" = "findOneBySlug"})
     * @ParamConverter("translation", class="AppBundle:Crowding\Translation")
     * @Security("has_role('ROLE_USER') && domain.getUser() == user && domain == translation.getDomain()")
     */
    public function putDomainTranslationsAction(Request $request, $domain, $translation)
    {
        $form = $this->createForm("AppBundle\Form\DomainTranslationUpdateType", [], ['csrf_protection' => false, 'method' => 'PUT']);
        $form->handleRequest($request, false);
        if ($form->isValid()) {
            $datas = $form->getData();
            $translation
                ->setCode($datas['code'] ?? $translation->getCode())
            ;
            foreach ($datas['trans'] as $key => $value) {
                if (array_search($key, $domain->getVirtualLangs()) === false)
                    throw new \Exception("Lang not accepted", 400);
                if ($lang = $translation->getTransByLang($key)) {
                    $lang->setTrans($value);
                } else {
                    $lang = new \AppBundle\Entity\Crowding\TranslationToLang;
                    $lang
                        ->setLang($this->get('doctrine')->getRepository('AppBundle\Entity\Crowding\Lang')->find($key))
                        ->setTrans($value)
                        ->setTranslation($translation)
                    ;
                    $translation->addTranslationToLang($lang);
                }
            }
            try {
                $this->get('doctrine')->getManager()->persist($translation);
                $this->get('doctrine')->getManager()->flush();
            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                throw new \Exception("Duplication du code dans le domain", 400);
            } catch (\Exception $e) {
                throw new \Exception("Une erreur est survenu recommence", 400);
            }

            $data = array(
                "code" => 200,
                "message" => "success",
                "datas" => $translation
            );
            $view = $this->view($data, 200);
            $context = new Context();
            $context->setGroups(['LIST', 'DETAIL']);
            $view->setContext($context);
            return $this->handleView($view);
        }
        $view = $this->view([
            'code'      => 400,
            'message'   => $form
        ], 400);
        return $this->handleView($view);
    }

    /**
     * @ParamConverter("domain", class="AppBundle:Crowding\Domain", options={"repository_method" = "findOneBySlug"})
     * @ParamConverter("translation", class="AppBundle:Crowding\Translation")
     * @Security("has_role('ROLE_USER') && domain.getUser() == user && domain == translation.getDomain()")
     */
    public function deleteDomainTranslationAction (Request $request, $domain, $translation)
    {   
        $translations = $translation->getTranslationToLang();
        foreach($translations as $trans) {
            $this->get('doctrine')->getManager()->remove($trans);
        }
        $token = $translation->getId();
        $this->get('doctrine')->getManager()->remove($translation);
        $this->get('doctrine')->getManager()->flush();

        $view = $this->view([
            "code" => 200,
            "message" => "success",
            "datas" => $token
        ], 200);
        return $this->handleView($view);
    }

    /**
     * @ParamConverter("domain", class="AppBundle:Crowding\Domain", options={"repository_method" = "findOneBySlug"})
     * @ParamConverter("lang", class="AppBundle:Crowding\Lang")
     * @Security("has_role('ROLE_USER') && domain.getUser() == user")
     */
    public function deleteDomainLangAction (Request $request, $domain, $lang)
    {
        if(!in_array($lang->getCode(), $domain->getVirtualLangs())) {
            throw new NotFoundHttpException("Langue non présente dans le domaine");
        }
        $translations = $domain->getTranslations();
        foreach ($translations as $trans) {
            if ($trans->getTransByLang($lang->getCode())) {
                $trans->removeTranslationToLang($trans->getTransByLang($lang->getCode()));
            }
        }
        $domain->removeLang($lang);
        $this->get('doctrine')->getManager()->flush();

        $view = $this->view([
            "code" => 200,
            "message" => "success",
            "datas" => $domain
        ], 200);
        return $this->handleView($view);
    }

    public function getLangsAction (Request $request)
    {
        $form = $this->createForm("AppBundle\Form\GetLangType");
    }
}
