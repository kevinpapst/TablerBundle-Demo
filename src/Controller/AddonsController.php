<?php

/*
 * This file is part of the Tabler-Bundle demo.
 * Copyright 2021 Kevin Papst - www.kevinpapst.de
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Service\TablerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddonsController extends AbstractController
{
    #[Route('/flags', name: 'addons_flags')]
    public function icons(TablerService $tablerService): Response
    {
        return $this->render('addons/flags.html.twig', [
            'flags' => $tablerService->flags(),
        ]);
    }

    #[Route('/payment-providers', name: 'addons_payment_providers')]
    public function paymentProviders(TablerService $tablerService): Response
    {
        return $this->render('addons/payment-providers.html.twig', [
            'payments' => $tablerService->payments(),
        ]);
    }
}
