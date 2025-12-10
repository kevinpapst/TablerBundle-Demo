<?php

namespace App\Controller;

use App\Service\GithubService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(
        GithubService $githubService,
    ): Response {
        return $this->render('dashboard/index.html.twig', [
            'topContributors' => $githubService->fetchTopContributors(),
            'commits'      => $githubService->fetchCommits(perPage: 5),
        ]);
    }
}
