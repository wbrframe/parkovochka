<?php

declare(strict_types=1);

namespace App\Controller\API\V10\Parking;

use App\Attribute\DTO;
use App\Controller\AbstractDtoBasedAction;
use App\DTO\Parking\NewParkingDto;
use App\Service\Entity\Parking\ParkingManager;
use App\Traits\EntityManagerTrait;
use App\Traits\SerializerTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[DTO(class: NewParkingDto::class)]
final class CreateParkingAction extends AbstractDtoBasedAction
{
    use EntityManagerTrait;
    use SerializerTrait;

    public function __construct(private readonly ParkingManager $parkingManager)
    {
    }

    #[Route(
        path: '/parkings',
        name: 'api_v1.0_create_parking',
        methods: [Request::METHOD_POST]
    )]
    public function __invoke(Request $request): Response
    {
        $this->validateJsonSchema($request);

        /** @var NewParkingDto $dto */
        $dto = $this->getDtoFromRequest($request);
        $this->validateDto($dto);

        $entity = $this->parkingManager->createEntityFromDto($dto);
        $this->validateEntity($entity);

        $this->em->persist($entity);
        $this->em->flush();

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
