<?php

declare(strict_types=1);

namespace App\Request;

use App\Exception\UnexpectedValueException;
use StfalconStudio\ApiBundle\Traits\RequestStackTrait;
use Symfony\Component\HttpFoundation\Request;

class RequestHelper
{
    use RequestStackTrait;

    final public const UUID_REGEX = '^[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}$';

    public function __construct(private readonly string $defaultLocale, private readonly array $supportedLocales)
    {
    }

    public function getLocale(): string
    {
        $request = $this->requestStack->getMainRequest();

        if (!$request instanceof Request) {
            throw new UnexpectedValueException('Request is missed');
        }

        return $request->getLocale();
    }

    public function getCurrentLocale(): string
    {
        $locale = $this->requestStack->getCurrentRequest()?->getLocale();

        return (\is_string($locale) && \in_array($locale, $this->supportedLocales, true)) ? $locale : $this->defaultLocale;
    }
}
