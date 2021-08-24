<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LoginRolesSuscriberSubscriber implements EventSubscriberInterface
{
    private $urlGenerator;
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }
    public function onLoginSuccessEvent(LoginSuccessEvent $event)
    {
        $user  = $event->getUser();
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