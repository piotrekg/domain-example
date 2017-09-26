<?php

declare(strict_types=1);

namespace App\Domain\Wine;

use App\Domain\Grape\Grape;
use App\Domain\Wine\Exception\GrapeAlreadyExists;
use App\Domain\Wine\Exception\InvalidContentsException;
use App\Domain\Wine\Exception\InvalidTotalContentsException;
use App\Domain\Wine\Exception\TooManyGrapesException;
use App\Domain\Wine\Exception\WineLabelTooLongException;

/**
 * Class Wine.
 */
class Wine
{
    const GLUE = ', ';
    const MAX_LABEL_LENGTH = 50;
    const MAX_GRAPES = 4;

    /**
     * @var Grape[]
     */
    private $grapes;

    /**
     * Wine constructor.
     */
    public function __construct()
    {
        $this->grapes = [];
    }

    /**
     * @return array
     */
    public function getGrapes(): array
    {
        $grapes = $this->grapes;

        usort($grapes, function (Grape $a, Grape $b): bool {
            if ($a->getContents() < $b->getContents()) {
                return true;
            }

            if ($a->getContents() > $b->getContents()) {
                return false;
            }

            return $a->getName() > $b->getName();
        });

        return $grapes;
    }

    /**
     * @param Grape $grape
     * @param int   $contents
     *
     * @throws GrapeAlreadyExists
     * @throws TooManyGrapesException
     * @throws WineLabelTooLongException
     *
     * @return Wine
     */
    public function addGrape(Grape $grape, int $contents): Wine
    {
        if (true === $this->contains($grape)) {
            throw new GrapeAlreadyExists($grape);
        }

        if (self::MAX_LABEL_LENGTH < $length = strlen($this->label())) {
            throw new WineLabelTooLongException(
                self::MAX_LABEL_LENGTH,
                $length,
                $grape
            );
        }

        if (self::MAX_GRAPES <= $this->count()) {
            throw new TooManyGrapesException(self::MAX_GRAPES);
        }

        if (0 >= $contents || 100 <= $contents) {
            throw new InvalidContentsException($grape, $contents);
        }

        if (100 < $totalContents = $this->sumContents() + $contents) {
            throw new InvalidTotalContentsException($totalContents);
        }

        $this->grapes[] = $grape->addContents($contents);

        return $this;
    }

    /**
     * @return string
     */
    public function label(): string
    {
        return implode(self::GLUE, $this->getGrapes());
    }

    /**
     * @param Grape $grape
     *
     * @return bool
     */
    public function contains(Grape $grape): bool
    {
        foreach ($this->grapes as $item) {
            if (true === $item->equals($grape)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->grapes);
    }

    /**
     * @return int
     */
    public function sumContents(): int
    {
        $contents = 0;
        foreach ($this->grapes as $grape) {
            $contents += $grape->getContents();
        }

        return $contents;
    }
}
