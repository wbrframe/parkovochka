<?php

declare(strict_types=1);

namespace App\Controller\Landing;

use StfalconStudio\ApiBundle\Traits\TwigTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexAction
{
    use TwigTrait;

    #[Route(path: '/', name: 'landing_index', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        $result = $this->twig->render('landing/index.html.twig');

        return new Response($result);
    }
}
