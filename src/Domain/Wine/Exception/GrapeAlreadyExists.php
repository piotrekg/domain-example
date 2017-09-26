<?php

declare(strict_types=1);

namespace App\Domain\Wine\Exception;

use App\Domain\Grape\Grape;

class GrapeAlreadyExists extends WineValidationException
{
    /**
     * GrapeAlreadyExists constructor.
     *
     * @param Grape $grape
     */
    public function __construct(Grape $grape)
    {
        parent::__construct(sprintf(
            'Grape "%s" already exists!',
            $grape->getName()
        ));
    }
}
