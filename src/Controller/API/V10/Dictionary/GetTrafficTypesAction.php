<?php

declare(strict_types=1);

namespace App\Controller\API\V10\Dictionary;

use App\Enum\TrafficEnum;
use StfalconStudio\ApiBundle\Traits\SerializerTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GetTrafficTypesAction
{
    use SerializerTrait;

    #[Route(path: '/dictionaries/traffic-types', name: 'api_v1.0_get_traffic_types', methods: [Request::METHOD_GET])]
    public function __invoke(): JsonResponse
    {
        $data = $this->serializer->serialize(TrafficEnum::cases(), 'json');

        return new JsonResponse(data: $data, json: true);
    }
}
