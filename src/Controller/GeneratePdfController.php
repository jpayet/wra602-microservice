<?php

namespace App\Controller;

use App\Service\GotenbergService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;

class GeneratePdfController extends AbstractController
{
    #[Route('/generate-pdf', name: 'app_generate_pdf')]
    public function index(GotenbergService $gotenbergService, ParameterBagInterface $parameterBag): StreamedResponse
    {
        $gotenberg_api = $parameterBag->get('microservice_host');
        $content = $gotenbergService->generatePdf($gotenberg_api);

        return new StreamedResponse(function () use ($content) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="my-pdf.pdf"');

            echo $content;
        });
    }
}
