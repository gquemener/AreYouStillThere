<?php

namespace AreYou\StillThereBundle\Controller;

use AreYou\StillThereBundle\Document\Heartbeat;

class UserController extends Controller
{
    public function showAction($username)
    {
        if ('me' === $username) {
            $user = $this->getUser();
        }

        return $this->render('AreYouStillThereBundle:User:show.html.twig', [
            'user' => $user,
        ]);
    }

    public function isAliveAction()
    {
        $user = $this->getUser();
        $heartbeat = new Heartbeat();
        $user->addHeartbeats($heartbeat);

        $dm = $this->getDocumentManager();
        $dm->persist($user);
        $dm->persist($heartbeat);
        $dm->flush();

        return $this->redirect($this->generateUrl('hearbeat'));
    }
}
