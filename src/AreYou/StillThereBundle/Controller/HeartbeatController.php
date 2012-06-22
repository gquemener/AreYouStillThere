<?php

namespace AreYou\StillThereBundle\Controller;

use AreYou\StillThereBundle\Document\Heartbeat;

class HeartbeatController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();

        return $this->render('AreYouStillThereBundle:Heartbeat:index.html.twig', [
            'user' => $user,
        ]);
    }

    public function sendAction()
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
