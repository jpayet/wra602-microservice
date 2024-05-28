<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GotenbergService
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function fetchGotenbergAPI($gotenbergApi): string
    {
        $response = $this->client->request(
            'GET',
            $gotenbergApi.'/health'
        );

        $content = $response->getContent();

        return $content;
    }

    public function generatePdfHtml($gotenbergApi, $filePath): string
    {
        $response = $this->client->request(
            'POST',
            $gotenbergApi.'/forms/chromium/convert/html',
            [
                'headers' => [
                    'Content-Type'=>'multipart/form-data'
                ],
                'body' => [
                    'files' => [
                        'file' => [
                            'name' => 'file',
                            'contents' => fopen($filePath, 'r')
                        ],
                    ],
                ],
            ]
        );
        $content = $response->getContent();
        return $content;
    }

    public function generatePdfUrl($gotenbergApi, $url): string
    {
        $response = $this->client->request(
            'POST',
            $gotenbergApi.'/forms/chromium/convert/url',
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

