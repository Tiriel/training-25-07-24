<?php

namespace App\Movie\Consumer;

use App\Movie\Enum\SearchType;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OmdbApiConsumer
{
    public function fetch(string $value, SearchType $type): array
    {
        $client = HttpClient::create();
        $data = $client->request(
            'GET',
            'https://www.omdbapi.com',
            [
                'query' => [
                    'plot' => 'full',
                    'apikey' => '',
                    $type->label() => $value
                ]
            ]
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
