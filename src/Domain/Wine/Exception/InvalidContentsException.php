<?php

declare(strict_types=1);

namespace App\Domain\Wine\Exception;

use App\Domain\Grape\Grape;

class InvalidContentsException extends WineValidationException
{
    /**
     * InvalidContentsException constructor.
     *
     * @param Grape $grape
     * @param int   $contents
     */
    public function __construct(Grape $grape, $contents)
    {
        parent::__construct(sprintf(
            'Grape "%s" has invalid contents: %s',
            $grape,
            $contents
        ));
    }
}
