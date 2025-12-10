<?php

namespace App\Model;

use Symfony\Component\Serializer\Attribute\SerializedName;

final class GithubCommit
{
    public function __construct(
        #[SerializedName('sha')]
        private readonly string $sha,

        #[SerializedName('node_id')]
        private readonly string $nodeId,

        #[SerializedName('commit')]
        private readonly GithubCommitDetails $commit,

        #[SerializedName('url')]
        private readonly string $apiUrl,

        #[SerializedName('html_url')]
        private readonly string $htmlUrl,

        #[SerializedName('comments_url')]
        private readonly string $commentsUrl,

        #[SerializedName('author')]
        private readonly ?GithubUser $author = null,

        #[SerializedName('committer')]
        private readonly ?GithubUser $committer = null,
    ) {
    }

    public function getSha(): string
    {
        return $this->sha;
    }

    public function getNodeId(): string
    {
        return $this->nodeId;
    }

    public function getCommit(): GithubCommitDetails
    {
        return $this->commit;
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    public function getHtmlUrl(): string
    {
        return $this->htmlUrl;
    }

    public function getCommentsUrl(): string
    {
        return $this->commentsUrl;
    }

    public function getAuthor(): ?GithubUser
    {
        return $this->author;
    }

    public function getCommitter(): ?GithubUser
    {
        return $this->committer;
    }
}
