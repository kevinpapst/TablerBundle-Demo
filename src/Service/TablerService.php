<?php

/*
 * This file is part of the Tabler-Bundle demo.
 * Copyright 2021 Kevin Papst - www.kevinpapst.de
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Model\TablerFlag;
use App\Model\TablerPayment;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class TablerService
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
        private readonly DenormalizerInterface $denormalizer,
    ) {
    }

    /**
     * @return TablerPayment[]
     */
    public function payments(): array
    {
        return $this->serializer->denormalize(
            json_decode(file_get_contents($this->dataDir() . DIRECTORY_SEPARATOR . 'payments.json')),
            TablerPayment::class . '[]',
            'json'
        );
    }

    /**
     * @return TablerFlag[]
     */
    public function flags(): array
    {
        return $this->denormalizer->denormalize(
            json_decode(file_get_contents($this->dataDir() . DIRECTORY_SEPARATOR . 'flags.json')),
            TablerFlag::class . '[]',
            'json'
        );
    }

    private function dataDir(): string
    {
        return $this->resourceDir()
            . DIRECTORY_SEPARATOR . 'data';
    }

    private function resourceDir(): string
    {
        return $this->parameterBag->get('kernel.project_dir')
            . DIRECTORY_SEPARATOR . 'src'
            . DIRECTORY_SEPARATOR . 'Resources'
            . DIRECTORY_SEPARATOR . 'Tabler';
    }
}
