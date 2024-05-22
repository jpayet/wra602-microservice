<?php

namespace App\Controller;

use App\Service\GotenbergService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;

class GeneratePdfController extends AbstractController
{
    #[Route('/generate-pdf-html', name: 'app_generate_pdf_html', methods: ['POST'])]
    public function generatePdfHtml(GotenbergService $gotenbergService, ParameterBagInterface $parameterBag, Request $request): StreamedResponse
    {
        $gotenberg_api = $parameterBag->get('microservice_host');
        $file = $request->files->get('index.html');
        $content = $gotenbergService->generatePdfHtml($gotenberg_api, $file);

        return new StreamedResponse(function () use ($content) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="my-pdf.pdf"');

            echo $content;
        });
    }

    #[Route('/generate-pdf-url', name: 'app_generate_pdf_url', methods: ['POST'])]
    public function generatePdfUrl(GotenbergService $gotenbergService, ParameterBagInterface $parameterBag, Request $request): StreamedResponse
    {
        $gotenberg_api = $parameterBag->get('microservice_host');
        $url = $request->request->get('url');
        $content = $gotenbergService->generatePdfUrl($gotenberg_api, $url);

        return new StreamedResponse(function () use ($content) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="my-pdf.pdf"');

            echo $content;
        });
    }

}
