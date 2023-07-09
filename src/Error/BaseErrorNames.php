<?php

declare(strict_types=1);

namespace App\Error;

class BaseErrorNames
{
    // 400
    final public const MISSED_REQUIRED_HEADER = 'missed_required_header';
    final public const MALFORMED_JSON = 'malformed_json';
    final public const INVALID_JSON_SCHEMA = 'invalid_json_schema';
    final public const INCORRECT_HEADER = 'incorrect_header';
    final public const INVALID_REQUEST = 'invalid_request';

    // 404
    final public const RESOURCE_NOT_FOUND = 'resource_not_found';

    // 405
    final public const METHOD_NOT_ALLOWED = 'method_not_allowed';

    // 422
    final public const INVALID_ENTITY = 'invalid_entity';

    // 500
    final public const INTERNAL_SERVER_ERROR = 'internal_server_error';

    /**
     * Constructor.
     */
    private function __construct()
    {
        // noop
    }
}
