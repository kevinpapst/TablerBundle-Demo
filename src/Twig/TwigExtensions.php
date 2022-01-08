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
use Twig\Extra\Markdown\ErusevMarkdown;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TwigExtensions extends AbstractExtension
{
    /**
     * @var string[]
     */
    private $locales;

    public function __construct(string $locales)
    {
        $this->locales = explode('|', trim($locales));
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('language', [$this, 'getLanguageName']),
            new TwigFilter('markdown', [$this, 'markdown'], ['is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('locales', [$this, 'getLocales']),
        ];
    }

    /**
     * @return string[]
     */
    public function getLocales(): array
    {
        return $this->locales;
    }

    public function markdown(string $markdown): string
    {
        $parser = new \Parsedown();

        return $parser->parse($markdown);
    }

    public function getLanguageName(string $language): string
    {
        return ucfirst(Locales::getName($language, $language));
    }
}
