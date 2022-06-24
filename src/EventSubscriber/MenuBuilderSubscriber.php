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
            new MenuItemModel('homepage', 'homepage', 'homepage', [], 'fas fa-tachometer-alt')
        );

        $forms = new MenuItemModel('forms', 'Forms', null, [], 'fab fa-wpforms');
        $forms->setBadgeColor('red');

        $forms->addChild(
            new MenuItemModel('forms', 'Regular', 'forms', [], 'fab fa-wpforms')
        );
        $forms->addChild(
            new MenuItemModel('sub-demo', 'Horizontal', 'forms-horizontal', [], 'far fa-arrow-alt-circle-down')
        );
        $formSub = new MenuItemModel('form-second-level', 'Deeper menus', null, [], 'far fa-arrow-alt-circle-right');
        $formSub->addChild(new MenuItemModel('form-second-level2', 'Third level is possible', 'third_level'));
        $formSub->addChild(new MenuItemModel('form-second-level2', 'Third level is possible 2', 'third_level2'));
        $forms->addChild($formSub);

        $event->addItem($forms);

        $components = new MenuItemModel('components', 'Components', null, []);
        $components->addChild(new MenuItemModel('buttons', 'Buttons', 'buttons', [], 'far fa-save'));
        $components->addChild(new MenuItemModel('timeline', 'Timeline', 'timeline', [], 'fas fa-stream'));
        $components->addChild(new MenuItemModel('dropdown', 'Dropdown', 'dropdown', [], 'far fa-save'));
        $components->addChild(new MenuItemModel('alert', 'Alert', 'alert', [], 'fas fa-exclamation'));
        $components->addChild(new MenuItemModel('callout', 'Callout', 'callout', [], 'fas fa-exclamation'));
        $components->addChild(new MenuItemModel('offcanvas', 'Offcanvas', 'offcanvas', []));
        $components->addChild(new MenuItemModel('modal', 'Modals', 'modal', []));

        $event->addItem($components);

        $layouts = new MenuItemModel('layout', 'Layout', null, []);
        $layouts->addChild(
            new MenuItemModel('full-page', 'Full page layout', 'full-page', [], 'fas fa-desktop')
        );
        $layouts->addChild(
            new MenuItemModel('navbar-overlapping', 'Overlapping Navbar', 'navbar-overlapping', [])
        );
        $vertical = new MenuItemModel('navbar-vertical', 'Vertical Navbar', 'navbar-vertical', []);
        $vertical->setBadge('New');
        $vertical->setBadgeColor('green');
        $layouts->addChild($vertical);
        $layouts->setDivider(true);
        $layouts->addChild(
            new MenuItemModel('RTL', 'Right to left', 'layout-rtl', [])
        );
        $layouts->addChild(
            new MenuItemModel('Error 403', 'Error 403', 'error403', [], 'far fa-exclamation')
        );
        $layouts->addChild(
            new MenuItemModel('Error 404', 'Error 404', 'error404', [], 'far fa-bug'),
        );
        $layouts->addChild(
            new MenuItemModel('Error 500', 'Error 500', 'error500', [], 'far fa-bomb')
        );

        $event->addItem($layouts);

        $docu = new MenuItemModel('documentation', 'Documentation', 'documentation', [], 'far fa-file-alt');
        $docu->setBadgeColor('blue');
        $event->addItem($docu);

        if (!$this->security->isGranted('IS_AUTHENTICATED')) {
            $event->addItem(
                new MenuItemModel('login', 'login', 'security_login', [], 'fas fa-sign-in-alt')
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
