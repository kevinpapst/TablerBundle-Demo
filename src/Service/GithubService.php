<?php

/*
 * This file is part of the Tabler-Bundle demo.
 * Copyright 2021 Kevin Papst - www.kevinpapst.de
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Model\GithubCommit;
use App\Model\GithubUser;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubService
{
    final public const repository = 'kevinpapst/TablerBundle';

    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
        private readonly HttpClientInterface $httpClient,
        private readonly DenormalizerInterface $serializer,
    ) {
    }

    /**
     * @return GithubUser[]
     */
    public function fetchContributors(
        ?string $repository = null,
        int $perPage = 10,
        bool $asc = true,
    ): array {
        try {
            $contributorsResponse = $this->httpClient->request(
                'GET',
                \sprintf(
                    '%s/contributors?q=contributions&per_page=%s&order=%s',
                    $this->apiUrl($repository),
                    $perPage,
                    $asc ? 'asc' : 'desc',
                ),
            );

            return $this->serializer->denormalize(
                $contributorsResponse->toArray(),
                GithubUser::class . '[]',
                'array'
            );
        } catch (\Throwable) {
            return $this->serializer->denormalize(
                json_decode(file_get_contents($this->resourceDir() . DIRECTORY_SEPARATOR . 'contributors.json')),
                GithubUser::class . '[]',
                'json'
            );
        }
    }

    /**
     * @return GithubUser[]
     */
    public function fetchTopContributors(
        ?string $repository = null,
        int $perPage = 10,
    ): array {
        return $this->fetchContributors(repository: $repository, perPage: $perPage, asc: false);
    }

    /**
     * @return GithubCommit[]
     */
    public function fetchCommits(
        ?string $repository = null,
        string $branch = 'main',
        int $perPage = 10,
    ): array {
        try {
            $contributorsResponse = $this->httpClient->request(
                'GET',
                \sprintf(
                    '%s/commits?sha=%s&per_page=%s',
                    $this->apiUrl($repository),
                    $branch,
                    $perPage,
                ),
            );

            return $this->serializer->denormalize(
                $contributorsResponse->toArray(),
                GithubCommit::class . '[]',
                'array'
            );
        } catch (\Throwable) {
            return $this->serializer->denormalize(
                json_decode(file_get_contents($this->resourceDir() . DIRECTORY_SEPARATOR . 'commits.json')),
                GithubCommit::class . '[]',
                'json'
            );
        }
    }

    private function apiUrl(?string $repository = null): string
    {
        return \sprintf(
            'https://api.github.com/repos/%s',
            $repository ?? self::repository,
        );
    }

    private function resourceDir(): string
    {
        return $this->parameterBag->get('kernel.project_dir')
            . DIRECTORY_SEPARATOR . 'src'
            . DIRECTORY_SEPARATOR . 'Resources'
            . DIRECTORY_SEPARATOR . 'Github';
    }
}
