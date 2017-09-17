<?php

namespace AppBundle\Controller;

use AppBundle\Service\PageCrawler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/process/", name="process message")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function processAction(Request $request)
    {

        /** @var PageCrawler $crawlerService */
        $crawlerService = $this->container->get('app.page_crawler');

        $data = $request->request->get('request');

        $html = $crawlerService->getHtml($data);

        $crawlerService->parseHtml($html);

        $crawlerService->getCurrentPageEmails($html, $data);

        $crawlerService->getChildEmailAddress();

        var_dump($crawlerService->getEmails());

        return $this->render('default/blank.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }



}
