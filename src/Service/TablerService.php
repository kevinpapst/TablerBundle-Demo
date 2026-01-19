<?php

namespace App\Service;

use App\Model\TablerFlag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;

class TablerService
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
        private readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * @return TablerFlag[]
     */
    public function flags(): array
    {
        return $this->serializer->denormalize(
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
