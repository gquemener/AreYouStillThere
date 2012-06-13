<?php

namespace AreYou\StillThereBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $dm = $this->getDocumentManager();
        $user = $dm->getRepository('AreYouStillThereBundle:User')->findAll()->getNext();
        $json = json_encode($user);

        return new Response($json, 200, ['Content-Type' => 'application/json']);
    }
    
    private function getDocumentManager()
    {
        return $this->get('doctrine.odm.mongodb.default_document_manager');
    }
}
