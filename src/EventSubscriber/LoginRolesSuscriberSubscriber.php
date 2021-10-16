<?php

namespace App\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LoginRolesSuscriberSubscriber implements EventSubscriberInterface
{
    private $urlGenerator;
    private $entityManager;
    public function __construct(UrlGeneratorInterface $urlGenerator, EntityManagerInterface $entityManager)
    {
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
    }
    public function onLoginSuccessEvent(LoginSuccessEvent $event)
    {
        $user  = $event->getUser();
        $user->setLastLoginAt(new \DateTime());
        $this->entityManager->flush($user);
        if(in_array('ROLE_CLIENT', $user->getRoles())){
            $event->setResponse(new RedirectResponse($this->urlGenerator->generate('client_index')));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccessEvent',
        ];
    }
}