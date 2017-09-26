<?php

declare(strict_types=1);

namespace App\Bundle\WineBundle\Service;

use App\Domain\Wine\Wine;

class WineLabelService
{
    /**
     * As far I moved validation to Wine object, here is nothing to catch/rethrow
     *
     * @param Wine $wine
     *
     * @return string
     */
    public function generateGrapesLabel(Wine $wine): string
    {
        // ¯\_(ツ)_/¯
        return $wine->label();
    }
}
