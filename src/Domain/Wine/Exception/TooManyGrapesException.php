<?php

declare(strict_types=1);

namespace App\Domain\Wine\Exception;

class TooManyGrapesException extends WineValidationException
{
    /**
     * TooManyGrapesException constructor.
     *
     * @param int $max
     */
    public function __construct(int $max)
    {
        parent::__construct(sprintf(
            'Cannot add more than %d grapes to wine.',
            $max
        ));
    }
}
