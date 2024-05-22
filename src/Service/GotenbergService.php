<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GotenbergService
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function fetchGotenbergAPI($gotenberg_api): string
    {
        $response = $this->client->request(
            'GET',
            $gotenberg_api.'/health'
        );

        $content = $response->getContent();

        return $content;
    }

    public function generatePdfHtml($gotenberg_api, $file): string
    {
        $response = $this->client->request(
            'POST',
            $gotenberg_api.'/forms/chromium/convert/html',
            [
                'headers' => [
                    'Content-Type'=>'multipart/form-data'
                ],
                'body' => [
                    'files' => [
                        'file' => [
                            'name' => 'file',
                            'contents' => $file,
                        ],
                    ],
                ],
//                'body' => [
//                    'files' => [
//                        'file' => [
//                            'name' => 'file',
//                            'contents' => fopen(__DIR__.'/../../templates/pdf/index.html', 'r'),
//                        ],
//                    ],
//                ],
            ]
        );
        $content = $response->getContent();
        return $content;
    }

    public function generatePdfUrl($gotenberg_api, $url): string
    {
        $response = $this->client->request(
            'POST',
            $gotenberg_api.'/forms/chromium/convert/url',
            [
                'headers' => [
                    'Content-Type'=>'multipart/form-data'
                ],
                'body' => [
                    'url' => $url,
                ],
            ]
        );

        $content = $response->getContent();
        return $content;
    }
}

