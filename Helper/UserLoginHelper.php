<?php

namespace UserBundle\Helper;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UserLoginHelper
{
    const FIREWALL_MAIN = 'main';
    const INTERACTIVE_LOGIN_EVENT = 'security.interactive_login';

    private $securityTokenStorage;
    private $eventDispatcher;

    public function __construct(TokenStorageInterface $securityTokenStorage, EventDispatcherInterface $eventDispatcher)
    {
        $this->securityTokenStorage = $securityTokenStorage;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function interactiveLogin(UserInterface $user, Request $request)
    {
        if (!$user) {
            throw new UsernameNotFoundException('User not found');
        }

        $token = new UsernamePasswordToken($user, null, self::FIREWALL_MAIN, $user->getRoles());
        $this->securityTokenStorage->setToken($token);
        $event = new InteractiveLoginEvent($request, $token);
        $this->eventDispatcher->dispatch(self::INTERACTIVE_LOGIN_EVENT, $event);
    }
}
