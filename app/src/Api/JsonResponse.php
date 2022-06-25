<?php

namespace App\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class JsonResponse extends Response
{
    public SerializerInterface $serializer;

    public function __construct(
        string $jsonData,
        int $responseCode = 200,
        array $headers = []
    )
    {
        parent::__construct(
            $jsonData,
            $responseCode,
            array_merge($headers, ['Content-Type' => 'application/json;charset=UTF-8'])
        );
    }
}