<?php

namespace AreYou\StillThereBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AreYou\StillThereBundle\Document\Heartbeat;
use AreYou\StillThereBundle\Form\HeartbeatType;

class UserController extends Controller
{
    public function showAction($username)
    {
        if ('me' === $username) {
            $user = $this->getUser();
        } else {
            $user = $this->findUserOr404($username);
        }

        $heartbeat   = new Heartbeat();
        $isAliveForm = $this->getIsAliveForm($heartbeat);

        return $this->render('AreYouStillThereBundle:User:show.html.twig', [
            'user'          => $user,
            'is_alive_form' => $isAliveForm->createView(),
        ]);
    }

    public function isAliveAction(Request $request, $username)
    {
        if ('me' === $username) {
            $user = $this->getUser();
        }

        $heartbeat = new Heartbeat();
        $form = $this->getHeartbeatForm($heartbeat);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $dm = $this->getDocumentManager();

            $heartbeat->setUser($user);
            $dm->persist($heartbeat);

            $dm->flush();
        }

        return $this->redirect($this->generateUrl('show_user', array('username' => 'me')));
    }

    public function followAction(Request $request, $username)
    {
        $user = $this->findUserOr404($username);
        $currentUser = $this->getUser();

        $user->addFollower($currentUser);

        $this->getDocumentManager()->flush();

        return $this->redirect($this->generateUrl('show_user', array('username' => $username)));
    }

    public function unfollowAction(Request $request, $username)
    {
        $user = $this->findUserOr404($username);
        $currentUser = $this->getUser();

        $user->removeFollower($currentUser);

        $this->getDocumentManager()->flush();

        return $this->redirect($this->generateUrl('show_user', array('username' => $username)));
    }

    private function getIsAliveForm($heartbeat)
    {
        return $this->createForm(
            new HeartbeatType(),
            $heartbeat
        );
    }

}
