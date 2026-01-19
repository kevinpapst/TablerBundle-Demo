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

final class TablerPayment
{
    public function __construct(
        #[SerializedName('name')]
        private readonly string $name,
        #[SerializedName('logo')]
        private readonly string $logo,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }
}
