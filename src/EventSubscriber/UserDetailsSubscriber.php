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
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\InMemoryUser;

class UserDetailsSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly Security $security
    ) {
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

        // ** User
        $user = new UserModel('1', $myUser->getUserIdentifier());
        $user->setName('Kevin Papst');
        $user->setTitle('Software engineer');
        $user->setAvatar('https://avatars.githubusercontent.com/u/533162?v=4&s=60');
        $event->setUser($user);

        // ** MenuItems
        $status = new MenuItemModel('status', 'Status');
        $status->setDisabled(true);
        $event->addLink($status);

        $event->addLink(new MenuItemModel('profile', 'My profile', 'profile'));

        $feedback = new MenuItemModel('feedback', 'Feedback');
        $feedback->setDisabled(true);
        $event->addLink($feedback);

        $settings = new MenuItemModel('settings', 'Settings');
        $settings->setDisabled(true);
        $event->addLink($settings);
    }
}
