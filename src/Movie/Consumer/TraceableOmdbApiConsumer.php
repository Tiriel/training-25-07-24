<?php

namespace App\Movie\Consumer;

use App\Movie\Consumer\OmdbApiConsumer;
use App\Movie\Enum\SearchType;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[When('dev')]
#[AsDecorator(OmdbApiConsumer::class, priority: 10)]
class TraceableOmdbApiConsumer extends OmdbApiConsumer
{
    public function __construct(
        protected readonly OmdbApiConsumer $inner,
        protected readonly LoggerInterface $logger,
    )
    {
    }

    public function fetch(string $value, SearchType $type): array
    {
        $this->logger->info(sprintf("Caling OmdbApi for movie with %s \"%s\"", $type->label(), $value));

        return $this->inner->fetch($value, $type);
    }
}
