<?php

namespace App\Controller;

use App\Document\Aliment;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlimentController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private DocumentManager $documentManager
    ) { }

    #[Route('/aliments', name: 'app_get_aliments', methods: 'GET')]
    public function getAlimentsAction(): Response
    {
        $aliments = $this->documentManager->getRepository(Aliment::class)->findAll();

        return new Response(
            $this->serializer->serialize($aliments, JsonEncoder::FORMAT),
            200,
            ['Content-Type' => 'application/json;charset=UTF-8']
        );
    }
}