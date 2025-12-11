<?php

/*
 * This file is part of the Tabler-Bundle demo.
 * Copyright 2021 Kevin Papst - www.kevinpapst.de
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model;

use Symfony\Component\Serializer\Attribute\SerializedName;

final class GithubUser
{
    public function __construct(
        #[SerializedName('login')]
        private readonly string $login,
        #[SerializedName('id')]
        private readonly int $id,
        #[SerializedName('node_id')]
        private readonly string $nodeId,
        #[SerializedName('avatar_url')]
        private readonly string $avatarUrl,
        #[SerializedName('gravatar_id')]
        private readonly ?string $gravatarId,
        #[SerializedName('url')]
        private readonly string $apiUrl,
        #[SerializedName('html_url')]
        private readonly string $htmlUrl,
        #[SerializedName('followers_url')]
        private readonly string $followersUrl,
        #[SerializedName('following_url')]
        private readonly string $followingUrl,
        #[SerializedName('gists_url')]
        private readonly string $gistsUrl,
        #[SerializedName('starred_url')]
        private readonly string $starredUrl,
        #[SerializedName('subscriptions_url')]
        private readonly string $subscriptionsUrl,
        #[SerializedName('organizations_url')]
        private readonly string $organizationsUrl,
        #[SerializedName('repos_url')]
        private readonly string $reposUrl,
        #[SerializedName('events_url')]
        private readonly string $eventsUrl,
        #[SerializedName('received_events_url')]
        private readonly string $receivedEventsUrl,
        #[SerializedName('type')]
        private readonly string $type,
        #[SerializedName('user_view_type')]
        private readonly string $userViewType,
        #[SerializedName('site_admin')]
        private readonly bool $siteAdmin,
        #[SerializedName('contributions')]
        private readonly ?int $contributions,
    ) {
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNodeId(): string
    {
        return $this->nodeId;
    }

    public function getAvatarUrl(): string
    {
        return $this->avatarUrl;
    }

    public function getGravatarId(): ?string
    {
        return $this->gravatarId;
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    public function getHtmlUrl(): string
    {
        return $this->htmlUrl;
    }

    public function getFollowersUrl(): string
    {
        return $this->followersUrl;
    }

    public function getFollowingUrl(): string
    {
        return $this->followingUrl;
    }

    public function getGistsUrl(): string
    {
        return $this->gistsUrl;
    }

    public function getStarredUrl(): string
    {
        return $this->starredUrl;
    }

    public function getSubscriptionsUrl(): string
    {
        return $this->subscriptionsUrl;
    }

    public function getOrganizationsUrl(): string
    {
        return $this->organizationsUrl;
    }

    public function getReposUrl(): string
    {
        return $this->reposUrl;
    }

    public function getEventsUrl(): string
    {
        return $this->eventsUrl;
    }

    public function getReceivedEventsUrl(): string
    {
        return $this->receivedEventsUrl;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUserViewType(): string
    {
        return $this->userViewType;
    }

    public function isSiteAdmin(): bool
    {
        return $this->siteAdmin;
    }

    public function getContributions(): int
    {
        return $this->contributions;
    }
}
