<?php

declare(strict_types=1);

namespace App\Exception\Http\Json;

use App\Error\BaseErrorNames;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MalformedJsonException extends HttpException
{
    public function __construct(string $message = '', \Exception $previous = null)
    {
        parent::__construct(Response::HTTP_BAD_REQUEST, $message, $previous);
    }

    public function getErrorName(): string
    {
        return BaseErrorNames::MALFORMED_JSON;
    }
}
