<?php

declare(strict_types=1);

namespace App\Domain\Wine;

use App\Domain\Grape\Grape;
use App\Domain\Wine\Exception\GrapeAlreadyExists;
use App\Domain\Wine\Exception\InvalidContentsException;
use App\Domain\Wine\Exception\InvalidTotalContentsException;
use App\Domain\Wine\Exception\TooManyGrapesException;
use App\Domain\Wine\Exception\WineLabelTooLongException;
use PHPUnit\Framework\TestCase;

class WineTest extends TestCase
{
    public function testContains()
    {
        // given
        $wine = new Wine();
        $grape = Grape::create('Fetească neagră');

        // when
        $wine
            ->addGrape($grape, 50)
        ;

        // then
        $this->assertTrue($wine->contains($grape));
    }

    public function testCount()
    {
        // given
        $wine = new Wine();

        // when
        $wine
            ->addGrape(Grape::create('Fetească neagră'), 10)
            ->addGrape(Grape::create('Merlot'), 20)
            ->addGrape(Grape::create('Tempranillo'), 30)
            ->addGrape(Grape::create('Malbec'), 30)
        ;

        // then
        $this->assertEquals(4, $wine->count());
    }

    public function testCountContents()
    {
        // given
        $wine = new Wine();

        // when
        $wine
            ->addGrape(Grape::create('Fetească neagră'), 10)
            ->addGrape(Grape::create('Merlot'), 20)
            ->addGrape(Grape::create('Tempranillo'), 30)
            ->addGrape(Grape::create('Malbec'), 30)
        ;

        // then
        $this->assertEquals(90, $wine->countContents());
    }

    /**
     * data provider for invalid wine cases.
     *
     * @return array
     */
    public function invalidWineDataProvider()
    {
        $merlot = Grape::create('Merlot');
        $malbec = Grape::create('Malbec');
        $negroamaro = Grape::create('Negroamaro');
        $tempranillo = Grape::create('Tempranillo');
        $primitivo = Grape::create('Primitivo');

        return [
            [
                [
                    [$merlot, 110], // single grape contents exceeds 100
                ],
                InvalidContentsException::class,

            ],
            [
                [
                    [$merlot, 0], // single grape contents = 0
                ],
                InvalidContentsException::class,
            ],
            [
                [
                    [$merlot, -10], // single grape contents below 0
                ],
                InvalidContentsException::class,
            ],
            [
                [
                    [$merlot, 'a'], // contents value is not a number
                ],
                \TypeError::class,
            ],
            [
                [
                    [$merlot, 50], [$merlot, 50], // same grape added 2 times
                ],
                GrapeAlreadyExists::class,
            ],
            [
                [
                    [$merlot, 10], [$malbec, 10], // under 100%
                ],
            ],
            [
                [
                    [$merlot, 50], [$malbec, 80], // over 100%
                ],
                InvalidTotalContentsException::class,
            ],
            [
                [
                    [$merlot, 30], [$malbec, 30], [$negroamaro, 20], [$tempranillo, 10], [$primitivo, 10], // too many grapes
                ],
                TooManyGrapesException::class,
            ],
            [
                [
                    [Grape::create('Fetească neagră'), 50], [Grape::create('Fetească neagră with very long name'), 50], [Grape::create('Another Fetească neagră with even longer name'), 50],
                ],
                WineLabelTooLongException::class,
            ],
        ];
    }

    /**
     * @param array $grapeList
     *
     * @dataProvider invalidWineDataProvider
     */
    public function testValidateFailure(array $grapeList, $exception = null)
    {
        //when
        $wine = new Wine();

        // then
        if (null !== $exception) {
            $this->expectException($exception);
        } else {
            $this->assertTrue(true);
        }

        // given
        foreach ($grapeList as $grapeSet) {
            $wine->addGrape($grapeSet[0], $grapeSet[1]);
        }
    }
}
