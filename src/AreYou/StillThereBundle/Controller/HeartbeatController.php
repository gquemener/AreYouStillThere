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
        $user->addHeartbeats(new Heartbeat());
        $this->getDocumentManager()->flush();
    }
}
