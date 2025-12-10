<?php

namespace App\Model;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\SerializedName;

final class GitUser
{
    public function __construct(
        #[SerializedName('name')]
        private readonly string $name,

        #[SerializedName('email')]
        private readonly string $email,

        #[SerializedName('date')]
        private readonly DateTimeImmutable $date,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
