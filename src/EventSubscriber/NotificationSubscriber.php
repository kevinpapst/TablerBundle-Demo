<?php

/*
 * This file is part of the Tabler-Bundle demo.
 * Copyright 2021 Kevin Papst - www.kevinpapst.de
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use KevinPapst\TablerBundle\Event\NotificationEvent;
use KevinPapst\TablerBundle\Helper\Constants;
use KevinPapst\TablerBundle\Model\NotificationModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class NotificationSubscriber adds notification messages to the top bar.
 */
class NotificationSubscriber implements EventSubscriberInterface
{
    public function __construct(private AuthorizationCheckerInterface $security)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NotificationEvent::class => ['onNotifications', 100],
        ];
    }

    public function onNotifications(NotificationEvent $event): void
    {
        $event->addNotification(new NotificationModel('1', 'A demo message', Constants::TYPE_SUCCESS));
        $event->addNotification(new NotificationModel('2', 'Another message', Constants::TYPE_ERROR));
        $event->addNotification(new NotificationModel('3', 'Message 3', Constants::TYPE_INFO));
        $event->addNotification(new NotificationModel('4', 'Message 4', Constants::TYPE_WARNING));
        $event->addNotification(new NotificationModel('5', 'Message 5', Constants::TYPE_INFO));
        $event->addNotification(new NotificationModel('6', 'Message 6', Constants::TYPE_SUCCESS));

        if (!$this->security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return;
        }

        $event->addNotification(new NotificationModel('6', 'You are logged-in!', Constants::TYPE_SUCCESS));
    }
}
