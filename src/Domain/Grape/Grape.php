<?php

declare(strict_types=1);

namespace App\Domain\Grape;

class Grape
{
    /**
     * @var string grape name
     */
    private $name;

    /**
     * @var int
     */
    private $contents;

    /**
     * @param $name
     */
    private function __construct(string $name, int $contents = 0)
    {
        $this->name = $name;
        $this->contents = $contents;
    }

    /**
     * @param string $name
     *
     * @return Grape
     */
    public static function create(string $name): self
    {
        return new self($name);
    }

    public function addContents(int $contents): self
    {
        $copy = clone $this;
        $copy->contents = $contents;

        return $copy;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param Grape $grape
     *
     * @return bool
     */
    public function equals(Grape $grape): bool
    {
        return $grape->getName() === $this->name;
    }

    /**
     * @return int
     */
    public function getContents(): int
    {
        return $this->contents;
    }
}
