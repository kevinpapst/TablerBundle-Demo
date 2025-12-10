<?php

namespace App\Controller;

use App\Model\GithubContributor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(
        HttpClientInterface $httpClient,
        DenormalizerInterface $serializer,
    ): Response {
        try {
            $contributorsResponse = $httpClient->request(
                'GET',
                'https://api.github.com/repos/kevinpapst/TablerBundle/contributors?q=contributions&per_page=7&order=desc',
            );
            /** @var GithubContributor[] $contributors */
            $contributors = $serializer->denormalize(
                $contributorsResponse->toArray(),
                GithubContributor::class . '[]',
                'array'
            );
        } catch (\Throwable) {
            $contributors = [];
        }

        return $this->render('dashboard/index.html.twig', [
            'contributors' => $contributors,
        ]);
    }
}
