<?php

/*
 * This file is part of the Tabler-Bundle demo.
 * Copyright 2021 Kevin Papst - www.kevinpapst.de
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Twig;

use Symfony\Component\Intl\Locales;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigExtensions extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('language', [$this, 'getLanguageName']),
        ];
    }

    public function getLanguageName(string $language): string
    {
        return ucfirst(Locales::getName($language, $language));
    }
}
