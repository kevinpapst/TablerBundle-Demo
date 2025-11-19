<?php

/*
 * This file is part of the Tabler-Bundle demo.
 * Copyright 2021 Kevin Papst - www.kevinpapst.de
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Form\FormDemoModelType;
use KevinPapst\TablerBundle\Helper\ContextHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route(path: '/', name: 'homepage')]
    #[Route(path: '/third-level', name: 'third_level')]
    #[Route(path: '/third-level2', name: 'third_level2')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', []);
    }

    #[Route(path: '/forms', name: 'forms')]
    public function forms(Request $request): Response
    {
        $form = $this->createForm(FormDemoModelType::class);
        $form = $this->handleForm($request, $form);

        return $this->render('default/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/status', name: 'status')]
    public function status(): Response
    {
        return $this->render('components/status/status.html.twig');
    }

    #[Route(path: '/carousel', name: 'carousel')]
    public function carousel(): Response
    {
        return $this->render('components/carousels/carousels.html.twig');
    }

    #[Route(path: '/accordion', name: 'accordion')]
    public function accordion(): Response
    {
        return $this->render('components/accordion/accordion.html.twig');
    }

    #[Route(path: '/buttons', name: 'buttons')]
    public function buttons(): Response
    {
        return $this->render('components/buttons/buttons.html.twig');
    }

    #[Route(path: '/badges', name: 'badges')]
    public function badges(): Response
    {
        return $this->render('components/badges/badges.html.twig');
    }

    #[Route(path: '/dropdown', name: 'dropdown')]
    public function dropdown(): Response
    {
        return $this->render('components/dropdowns/dropdowns.html.twig');
    }

    #[Route(path: '/alert', name: 'alert')]
    public function alert(): Response
    {
        return $this->render('components/alerts/alerts.html.twig');
    }

    #[Route(path: '/callout', name: 'callout')]
    public function callout(): Response
    {
        return $this->render('components/callouts/callouts.html.twig');
    }

    #[Route(path: '/modal', name: 'modal')]
    public function modal(): Response
    {
        return $this->render('components/modals/modals.html.twig');
    }

    #[Route(path: '/progressbar', name: 'progressbar')]
    public function progressbar(): Response
    {
        return $this->render('components/progressbar/progressbar.html.twig');
    }

    #[Route(path: '/offcanvas', name: 'offcanvas')]
    public function offcanvas(): Response
    {
        return $this->render('components/offcanvas/offcanvas.html.twig');
    }

    #[Route(path: '/cardnav', name: 'cardnav')]
    public function cardnav(): Response
    {
        return $this->render('components/cardnav/cardnav.html.twig');
    }

    #[Route(path: '/cardnav_vertical', name: 'cardnav_vertical')]
    public function cardnavVertical(): Response
    {
        return $this->render('components/cardnav/vertical.html.twig');
    }

    #[Route(path: '/wizard/{page}', name: 'wizard', requirements: ['page' => "[1-9]\d*"], defaults: ['page' => 1])]
    public function wizard(string $page): Response
    {
        $page = (int) $page;

        if ($page > 10) {
            return $this->redirectToRoute('wizard', ['page' => 1]);
        }

        return $this->render('default/wizard.html.twig', [
            'page' => $page,
            'percent' => $page * 10,
        ]);
    }

    #[Route(path: '/timeline', name: 'timeline')]
    public function timeline(): Response
    {
        return $this->render('components/timelines/timelines.html.twig');
    }

    #[Route(path: '/full-page', name: 'full-page')]
    public function fullpage(): Response
    {
        return $this->render('default/fullpage.html.twig');
    }

    #[Route(path: '/documentation/{chapter}', name: 'documentation')]
    public function documentation(?string $chapter = null): Response
    {
        if ($chapter === null) {
            $chapter = 'index';
        }

        $docsDir = realpath(__DIR__ . '/../../vendor/kevinpapst/tabler-bundle/docs/') . '/';
        $fullUrl = $docsDir . $chapter . '.md';

        if (!file_exists($fullUrl)) {
            throw $this->createNotFoundException();
        }

        $markdown = file_get_contents($fullUrl);
        preg_match_all('/\((.*)\.md\)/', $markdown, $results, PREG_SET_ORDER);
        foreach ($results as $result) {
            $markdown = str_replace($result[0], '(' . $this->generateUrl('documentation', ['chapter' => $result[1]]) . ')', $markdown);
        }

        return $this->render('default/documentation.html.twig', [
            'chapter' => $chapter,
            'docs' => $markdown,
        ]);
    }

    #[Route(path: '/error-403', name: 'error403')]
    public function error403(): Response
    {
        throw $this->createAccessDeniedException();
    }

    #[Route(path: '/error-404', name: 'error404')]
    public function error404(): Response
    {
        throw $this->createNotFoundException();
    }

    #[Route(path: '/error-500', name: 'error500')]
    public function error500(): Response
    {
        throw new \RuntimeException('Oops');
    }

    #[Route(path: '/forms/horizontal', name: 'forms-horizontal')]
    public function forms2(Request $request): Response
    {
        $form = $this->createForm(FormDemoModelType::class);
        $form = $this->handleForm($request, $form);

        return $this->render('default/form-horizontal.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/profile', name: 'profile')]
    public function profile(Request $request): Response
    {
        return $this->render('default/profile.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    private function handleForm(Request $request, FormInterface $form): FormInterface
    {
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->addFlash('success', 'Fantastic work! You nailed it, form has no errors :-)');
            } else {
                $this->addFlash('danger', 'Form has errors ... please fix them!');
            }
        }

        return $form;
    }

    #[Route(path: '/dark-mode', name: 'dark-mode')]
    public function themeDark(RequestStack $requestStack): Response
    {
        $requestStack->getSession()->set('theme', 'dark');

        return $this->redirectToRoute('homepage');
    }

    #[Route(path: '/light-mode', name: 'light-mode')]
    public function themeLight(RequestStack $requestStack): Response
    {
        $requestStack->getSession()->remove('theme');

        return $this->redirectToRoute('homepage');
    }

    #[Route(path: '/navbar-overlapping', name: 'navbar-overlapping')]
    public function navbarOverlapping(ContextHelper $contextHelper): Response
    {
        $contextHelper->setIsNavbarOverlapping(true);

        return $this->render('default/index.html.twig', []);
    }

    #[Route(path: '/navbar-vertical', name: 'navbar-vertical')]
    public function navbarVertical(): Response
    {
        return $this->render('default/vertical-navbar.html.twig', []);
    }

    #[Route(path: '/right-to-left', name: 'layout-rtl')]
    public function rightToLeft(ContextHelper $contextHelper): Response
    {
        $contextHelper->setIsRightToLeft(true);

        return $this->render('default/index.html.twig', []);
    }

    #[Route(path: '/security-centered', name: 'security-centered')]
    public function securityCentered(ContextHelper $contextHelper): Response
    {
        return $this->render('login.html.twig', []);
    }

    #[Route(path: '/security-cover', name: 'security-cover')]
    public function securityCover(ContextHelper $contextHelper): Response
    {
        return $this->render('login-cover.html.twig', []);
    }
}
