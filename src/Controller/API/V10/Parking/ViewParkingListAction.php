<?php

declare(strict_types=1);

namespace App\Controller\API\V10\Parking;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ViewParkingListAction
{
    #[Route(path: '/parkings', name: 'api_v1.0_view_parkings_list', methods: [Request::METHOD_GET])]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse('[]', Response::HTTP_OK, [], true);
    }
}
