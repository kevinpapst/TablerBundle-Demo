<?php

/*
 * This file is part of the Tabler-Bundle demo.
 * Copyright 2021 Kevin Papst - www.kevinpapst.de
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use KevinPapst\TablerBundle\Helper\ContextHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class TablerContextSubscriber implements EventSubscriberInterface
{
    private $contextHelper;
    private $session;

    public function __construct(ContextHelper $contextHelper, SessionInterface $session)
    {
        $this->contextHelper = $contextHelper;
        $this->session = $session;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['prepareEnvironment', -100],
        ];
    }

    public function prepareEnvironment(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $theme = $this->session->get('theme');
        if ($theme === null) {
            return;
        }

        $this->contextHelper->setIsDarkMode($theme === 'dark');
    }
}
