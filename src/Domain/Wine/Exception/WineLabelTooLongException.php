<?php

declare(strict_types=1);

namespace App\Domain\Wine\Exception;

use App\Domain\Grape\Grape;

class WineLabelTooLongException extends \Exception
{
    /**
     * WineLabelTooLongException constructor.
     *
     * @param int   $maxLength
     * @param int   $length
     * @param Grape $grape
     */
    public function __construct(int $maxLength, int $length, Grape $grape)
    {
        parent::__construct(sprintf(
            'Wine label will be too long (%d) with label "%s", max: %d',
            $length,
            $grape->getName(),
            $maxLength
        ));
    }
}
