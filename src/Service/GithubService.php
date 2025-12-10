<?php

namespace App\Service;

use App\Model\GithubContributor;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubService
{
    final const repository = 'kevinpapst/TablerBundle';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly DenormalizerInterface $serializer,
    ) {
    }

    /**
     * @return GithubContributor[]
     */
    public function fetchContributors(
        ?string $repository = null,
        int $perPage = 10,
        bool $asc = true,
    ): array {
        try {
            $contributorsResponse = $this->httpClient->request(
                'GET',
                sprintf(
                    "%s/contributors?q=contributions&per_page=%s&order=%s",
                    $this->apiUrl($repository),
                    $perPage,
                    $asc ? 'asc' : 'desc',
                ),
            );

            return $this->serializer->denormalize(
                $contributorsResponse->toArray(),
                GithubContributor::class . '[]',
                'array'
            );
        } catch (\Throwable) {
            return [];
        }
    }

    private function apiUrl(?string $repository = null): string
    {
        return sprintf(
            "https://api.github.com/repos/%s",
            $repository ?? self::repository,
        );
    }
}
