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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Default controller
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", defaults={}, name="homepage")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', []);
    }

    /**
     * @Route("/forms", name="forms")
     */
    public function forms(Request $request): Response
    {
        $form = $this->createForm(FormDemoModelType::class);
        $form = $this->handleForm($request, $form);

        return $this->render('default/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/buttons", name="buttons")
     */
    public function buttons(): Response
    {
        return $this->render('components/buttons.html.twig');
    }

    /**
     * @Route("/dropdown", name="dropdown")
     */
    public function dropdown(): Response
    {
        return $this->render('components/dropdown.html.twig');
    }

    /**
     * @Route("/alert", name="alert")
     */
    public function alert(): Response
    {
        return $this->render('components/alert.html.twig');
    }

    /**
     * @Route("/timeline", name="timeline")
     */
    public function timeline(): Response
    {
        return $this->render('components/timeline.html.twig');
    }

    /**
     * @Route("/full-page", name="full-page")
     */
    public function fullpage(): Response
    {
        return $this->render('default/fullpage.html.twig');
    }

    /**
     * @Route("/documentation/{chapter}", name="documentation")
     */
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

    /**
     * @Route("/error-403", name="error403")
     */
    public function error403(): Response
    {
        throw $this->createAccessDeniedException();
    }

    /**
     * @Route("/error-404", name="error404")
     */
    public function error404(): Response
    {
        throw $this->createNotFoundException();
    }

    /**
     * @Route("/error-500", name="error500")
     */
    public function error500(): Response
    {
        throw new \RuntimeException('Oops');
    }

    /**
     * @Route("/forms/horizontal", name="forms-horizontal")
     */
    public function forms2(Request $request): Response
    {
        $form = $this->createForm(FormDemoModelType::class);
        $form = $this->handleForm($request, $form);

        return $this->render('default/form-horizontal.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request): Response
    {
        return $this->render('default/profile.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    protected function handleForm(Request $request, FormInterface $form): FormInterface
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

    /**
     * @Route("/dark-mode", name="dark-mode")
     */
    public function themeDark(SessionInterface $session): Response
    {
        $session->set('theme', 'dark');

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/light-mode", name="light-mode")
     */
    public function themeLight(SessionInterface $session): Response
    {
        $session->remove('theme');

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/navbar-overlapping", defaults={}, name="navbar-overlapping")
     */
    public function navbarOverlapping(ContextHelper $contextHelper): Response
    {
        $contextHelper->setIsNavbarOverlapping(true);

        return $this->render('default/index.html.twig', []);
    }

    /**
     * @Route("/navbar-vertical", defaults={}, name="navbar-vertical")
     */
    public function navbarVertical(): Response
    {
        return $this->render('default/vertical-navbar.html.twig', []);
    }
}
