<?php

/*
 * This file is part of the Tabler-Bundle demo.
 * Copyright 2021 Kevin Papst - www.kevinpapst.de
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
