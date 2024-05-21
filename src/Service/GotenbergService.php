<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GotenbergService
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function fetchGotenbergAPI(): string
    {
        $response = $this->client->request(
            'GET',
            $_ENV['GOTENBERG_API'].'/health'
        );

        $content = $response->getContent();

        return $content;
    }

    public function generatePdf(): string
    {
        $response = $this->client->request(
            'POST',
            $_ENV['GOTENBERG_API'].'/forms/chromium/convert/html',
            [
                'headers' => [
                    'Content-Type'=>'multipart/form-data'
                ],
                'body' => [
                    'files' => [
                        'file' => [
                            'name' => 'file',
                            'contents' => fopen(__DIR__.'/../../templates/pdf/index.html', 'r'),
                        ],
                    ],
                ],
            ]
        );
        $content = $response->getContent();
        return $content;
    }
}

