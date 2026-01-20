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

final class TablerFlag
{
    public function __construct(
        #[SerializedName('name')]
        private readonly string $name,
        #[SerializedName('flag')]
        private readonly string $flag,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFlag(): string
    {
        return $this->flag;
    }
}
