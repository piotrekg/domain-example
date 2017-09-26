<?php

declare(strict_types=1);

namespace App\Domain\Wine\Exception;

class InvalidTotalContentsException extends WineValidationException
{
    /**
     * InvalidTotalContentsException constructor.
     *
     * @param int $contents
     */
    public function __construct(int $contents)
    {
        parent::__construct(sprintf(
            'Contents in bottle cannot have more than 100%%, current: %d%%',
            $contents
        ));
    }
}
