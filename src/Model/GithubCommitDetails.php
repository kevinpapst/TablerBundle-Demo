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
