<?php

namespace App\Model;

use Symfony\Component\Serializer\Attribute\SerializedName;

final class GithubCommitDetails
{
    public function __construct(
        #[SerializedName('author')]
        private readonly GitUser $author,

        #[SerializedName('committer')]
        private readonly GitUser $committer,

        #[SerializedName('message')]
        private readonly string $message,
    ) {
    }

    public function getAuthor(): GitUser
    {
        return $this->author;
    }

    public function getCommitter(): GitUser
    {
        return $this->committer;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
