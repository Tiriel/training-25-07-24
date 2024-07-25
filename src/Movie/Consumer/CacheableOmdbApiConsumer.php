<?php

namespace App\Movie\Consumer;

use App\Movie\Consumer\OmdbApiConsumer;
use App\Movie\Enum\SearchType;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[When('prod')]
#[AsDecorator(OmdbApiConsumer::class, priority: 5)]
class CacheableOmdbApiConsumer extends OmdbApiConsumer
{
    public function __construct(
        protected readonly OmdbApiConsumer $inner,
        protected readonly CacheInterface $cache,
        protected readonly SluggerInterface $slugger,
    )
    {
    }

    public function fetch(string $value, SearchType $type): array
    {
        $key = $this->slugger->slug(sprintf("%s-%s", $type->label(), $value));

        return $this->cache->get(
            $key,
            fn() => $this->inner->fetch($value, $type)
        );
    }
}
