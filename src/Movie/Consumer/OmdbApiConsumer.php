<?php

namespace App\Movie\Consumer;

use App\Movie\Enum\SearchType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbApiConsumer
{
    public function __construct(
        protected readonly HttpClientInterface $omdbClient,
    )
    {
    }

    public function fetch(string $value, SearchType $type): array
    {
        $data = $this->omdbClient->request(
            'GET',
            '',
            ['query' => [$type->label() => $value]]
        )->toArray();

        if (\array_key_exists('Error', $data)) {
            if ($data['Error'] === 'Movie not found!') {
                throw new NotFoundHttpException($data['Error']);
            }

            throw new HttpException($data['Error']);
        }

        return $data;
    }
}
