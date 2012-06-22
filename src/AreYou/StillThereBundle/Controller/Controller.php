<?php

namespace AreYou\StillThereBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

class Controller extends BaseController
{
    public function getUserRepository()
    {
        return $this->getDocumentManager()->getRepository('AreYouStillThereBundle:User');
    }

    public function getHeartbeatRepository()
    {
        return $this->getDocumentManager()->getRepository('AreYouStillThereBundle:Heartbeat');
    }

    public function getDocumentManager()
    {
        return $this->get('doctrine.odm.mongodb.default_document_manager');
    }

    public function getUser()
    {
        if (null === $token = $this->container->get('security.context')->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        return $user;
    }
}
