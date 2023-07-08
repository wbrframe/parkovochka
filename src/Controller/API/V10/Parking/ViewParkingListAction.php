<?php

declare(strict_types=1);

namespace App\Controller\API\V10\Parking;

use App\Repository\Parking\ParkingRepository;
use App\Serializer\Groups\SerializationGroups;
use App\Traits\SerializerTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ViewParkingListAction
{
    use SerializerTrait;

    public function __construct(private readonly ParkingRepository $parkingRepository)
    {
    }

    #[Route(path: '/parkings', name: 'api_v1.0_view_parkings_list', methods: [Request::METHOD_GET])]
    public function __invoke(): JsonResponse
    {
        $parkings = [];
        foreach ($this->parkingRepository->iterable() as $entity) {
            $parkings[] = $entity;
        }

        $responseData = $this->serializer->serialize($parkings, SerializationGroups::LIST_PARKINGS_AS_ANONYMOUS);

        return new JsonResponse(data: $responseData, json: true);
    }
}
