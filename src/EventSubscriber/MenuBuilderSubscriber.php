<?php

/*
 * This file is part of the Tabler-Bundle demo.
 * Copyright 2021 Kevin Papst - www.kevinpapst.de
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use KevinPapst\TablerBundle\Event\MenuEvent;
use KevinPapst\TablerBundle\Model\MenuItemInterface;
use KevinPapst\TablerBundle\Model\MenuItemModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MenuBuilderSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MenuEvent::class => ['onSetupNavbar', 100],
        ];
    }

    public function onSetupNavbar(MenuEvent $event): void
    {
        $event->addItem(
            new MenuItemModel('homepage', 'menu.homepage', 'homepage', [], 'fas fa-tachometer-alt')
        );

        $forms = new MenuItemModel('forms', 'menu.form', 'forms', [], 'fab fa-wpforms');
        $forms->setBadge('1');
        $forms->setBadgeColor('red');
        $event->addItem($forms);

        $event->addItem(
            new MenuItemModel('context', 'Tabler context', 'context', [], 'fas fa-code')
        );

        $demo = new MenuItemModel('components', 'Components', null, []);
        $demo->setBadge('2');

        $demo->addChild(
            new MenuItemModel('sub-demo', 'Form - Horizontal', 'forms2', [], 'far fa-arrow-alt-circle-down')
        );
        $demo->addChild(
            new MenuItemModel('sub-demo2', 'Form - Sidebar', 'forms3', [], 'far fa-arrow-alt-circle-up')
        );
        $demo->addChild(
            new MenuItemModel('buttons', 'Buttons', 'buttons', [], 'far fa-button')
        );
        $event->addItem($demo);

        if ($this->security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $event->addItem(
                new MenuItemModel('logout', 'menu.logout', 'app_logout', [], 'fas fa-sign-out-alt')
            );
        } else {
            $event->addItem(
                new MenuItemModel('login', 'menu.login', 'app_login', [], 'fas fa-sign-in-alt')
            );
        }

        $this->activateByRoute(
            $event->getRequest()->get('_route'),
            $event->getItems()
        );
    }

    /**
     * @param string $route
     * @param MenuItemInterface[] $items
     */
    protected function activateByRoute(string $route, array $items): void
    {
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } elseif ($item->getRoute() == $route) {
                $item->setIsActive(true);
            }
        }
    }
}
