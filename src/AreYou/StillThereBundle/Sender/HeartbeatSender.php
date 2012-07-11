<?php

namespace AreYou\StillThereBundle\Sender;

use Symfony\Component\DependencyInjection\Container;
use AreYou\StillThereBundle\Document\User;

class HeartbeatSender
{
    private $from;
    private $mailer;
    private $container;

    public function __construct($from, Container $container)
    {
        $this->from       = $from;
        $this->container  = $container;
        $this->mailer     = $container->get('mailer');
    }

    private function getTemplating()
    {
        return $this->container->get('templating');
    }

    public function notify(User $user)
    {
        $followers = $user->getFollowers();

        foreach ($followers as $follower) {
            if ('' !== $follower->getEmail()) {
                $this->sendHeartbeatMail($user, $follower);
            }
        }
    }

    private function sendHeartbeatMail(User $user, User $follower)
    {
        $message = $this->createHeartbeatMessage($user, $follower);

        return $this->mailer->send($message);
    }

    private function createHeartbeatMessage(User $user, User $follower)
    {
        return \Swift_Message::newInstance()
            ->setSubject($this->renderSubject($user, $follower))
            ->setFrom($this->from)
            ->setTo($follower->getEmail())
            ->setBody($this->renderBody($user, $follower), 'text/html')
        ;
    }

    private function createNoHeartbeatMessage(User $user, User $follower)
    {
        return \Swift_Message::newInstance()
            ->setSubject($this->renderSubject($user, $follower, false))
            ->setFrom($this->from)
            ->setTo($follower->getEmail())
            ->setBody($this->renderBody($user, $follower, false), 'text/html')
        ;
    }

    private function renderSubject(User $user, User $follower, $isAlive = true)
    {
        if (true === $isAlive) {
            return $this->getTemplating()->render('AreYouStillThereBundle:Mail:heartbeat_subject.txt.twig', [
                'user'     => $user,
                'follower' => $follower,
            ]);
        } else {
            return $this->getTemplating()->render('AreYouStillThereBundle:Mail:no_heartbeat_subject.txt.twig', [
                'user'     => $user,
                'follower' => $follower,
            ]);
        }
    }

    private function renderBody(User $user, User $follower, $isAlive = true)
    {
        if (true === $isAlive) {
            return $this->getTemplating()->render('AreYouStillThereBundle:Mail:heartbeat_body.html.twig', [
                'user'     => $user,
                'follower' => $follower,
            ]);
        } else {
            return $this->getTemplating()->render('AreYouStillThereBundle:Mail:no_heartbeat_body.html.twig', [
                'user'     => $user,
                'follower' => $follower,
            ]);
        }
    }
}
