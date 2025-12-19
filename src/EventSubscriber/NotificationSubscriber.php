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
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class NotificationSubscriber adds notification messages to the top bar.
 */
class NotificationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NotificationEvent::class => ['onNotifications', 100],
        ];
    }

    public function onNotifications(NotificationEvent $event): void
    {
        $event->setTitle($this->translator->trans('My custom title'));
        $event->setTitleEmpty($this->translator->trans('No Item custom title'));
        $event->setBadgeColor('green');
        $event->setShowBadgeTotal(true);
        $event->setMaxDisplay(7);

        $activeNotification = new NotificationModel(
            'active',
            $this->translator->trans('My active Message'),
            Constants::TYPE_WARNING,
        );
        $activeNotification->setActive(true);
        $event->addNotification($activeNotification);

        $defaultNotification = new NotificationModel(
            'default',
            $this->translator->trans('My default Message'),
        );
        $event->addNotification($defaultNotification);

        $disabledNotification = new NotificationModel(
            'disabled',
            $this->translator->trans('My disabled Message'),
        );
        $disabledNotification->setDisabled(true);
        $disabledNotification->setBadgeAnimated(false);
        $event->addNotification($disabledNotification);

        $customizeNotification = new NotificationModel(
            'customize',
            $this->translator->trans('Link to Tabler'),
            Constants::TYPE_SUCCESS,
        );
        $customizeNotification->setBadgeAnimated(false);
        $customizeNotification->setUrl('https://preview.tabler.io/');
        $event->addNotification($customizeNotification);

        $htmlNotification = new NotificationModel(
            'html',
            '<div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                        <div class="col text-truncate">
                          <a href="#" class="text-body d-block">Example 1</a>
                          <div class="d-block text-muted text-truncate mt-n1">
                            Change deprecated html tags to text decoration classes (#29604)
                          </div>
                        </div>
                        <div class="col-auto">
                          <a href="#" class="list-group-item-actions">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path></svg>
                          </a>
                        </div>
                    </div>
                </div>',
        );
        $htmlNotification->setHtml(true);
        $event->addNotification($htmlNotification);

        $translatedMessage = $this->translator->trans('Notification with badge');
        $badgeNotification = new NotificationModel(
            'badge',
            <<<HTML
            <li class="list-group-item d-flex justify-content-between align-items-center">
                $translatedMessage
                <span class="badge badge-primary badge-pill">14</span>
            </li>
            HTML,
        );
        $badgeNotification->setHtml(true);
        $event->addNotification($badgeNotification);

        $flexBoxNotification = new NotificationModel(
            'flexbox',
            '<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">List group item heading</h5>
                  <small>3 days ago</small>
                </div>
                <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                <small>Donec id elit non mi porta.</small>
            </a>'
        );
        $flexBoxNotification->setHtml(true);
        $event->addNotification($flexBoxNotification);

        if (!$this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $event->addNotification(new NotificationModel('logged', 'You are logged-in!', Constants::TYPE_SUCCESS));
            $event->setMaxDisplay(8);
        }

        $moreThanMaxNotification = new NotificationModel(
            'max',
            'Will not be displayed as max notification is set to 7',
        );
        $event->addNotification($moreThanMaxNotification);

        $extraNotification = new NotificationModel('extra', 'One more not displayed');
        $event->addNotification($extraNotification);
    }
}
