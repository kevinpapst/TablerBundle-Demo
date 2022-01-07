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
     * @Route("/forms", defaults={}, name="forms")
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
     * @Route("/buttons", defaults={}, name="buttons")
     */
    public function buttons(): Response
    {
        return $this->render('components/buttons.html.twig');
    }

    /**
     * @Route("/full-page", defaults={}, name="full-page")
     */
    public function fullpage(): Response
    {
        return $this->render('default/fullpage.html.twig');
    }

    /**
     * @Route("/forms/horizontal", defaults={}, name="forms-horizontal")
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
     * @Route("/profile", defaults={}, name="profile")
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
                $this->addFlash('error', 'Form has errors ... please fix them!');
            }
        }

        return $form;
    }

    /**
     * @Route("/context", defaults={}, name="context")
     */
    public function context(): Response
    {
        return $this->render('default/context.html.twig', []);
    }

    /**
     * @Route("/dark-mode", defaults={}, name="dark-mode")
     */
    public function themeDark(SessionInterface $session): Response
    {
        $session->set('theme', 'dark');

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/light-mode", defaults={}, name="light-mode")
     */
    public function themeLight(SessionInterface $session): Response
    {
        $session->remove('theme');

        return $this->redirectToRoute('homepage');
    }
}
