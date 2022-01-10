<?php

/*
 * This file is part of the Tabler-Bundle demo.
 * Copyright 2021 Kevin Papst - www.kevinpapst.de
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use KevinPapst\TablerBundle\Event\UserDetailsEvent;
use KevinPapst\TablerBundle\Model\MenuItemModel;
use KevinPapst\TablerBundle\Model\UserModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\InMemoryUser;

class UserDetailsSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserDetailsEvent::class => ['onShowUser', 100],
        ];
    }

    public function onShowUser(UserDetailsEvent $event): void
    {
        if (null === $this->security->getUser()) {
            return;
        }

        /* @var $myUser InMemoryUser */
        $myUser = $this->security->getUser();

        $user = new UserModel('1', $myUser->getUserIdentifier());
        $user->setName('admin@example.com');
        $user->setTitle('demo user');
        //$user->setAvatar('bundles/tabler/images/default_avatar.png');

        $event->setUser($user);

        $profileLink = new MenuItemModel('profile', 'My profile', 'profile');
        $event->addLink($profileLink);
    }
}
