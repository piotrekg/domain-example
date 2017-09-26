<?php

declare(strict_types=1);

namespace App\Domain\Grape;

use PHPUnit\Framework\TestCase;

class GrapeTest extends TestCase
{
    public function testParameters()
    {
        // given
        $name = 'Merlot';

        // when
        $grape = Grape::create($name);

        // then
        $this->assertEquals($name, $grape->getName());
    }

    public function testEquals()
    {
        // given
        $name = 'Merlot';
        $grape = Grape::create($name);

        // when

        // then
        $this->assertTrue($grape->equals($grape));
        $this->assertTrue($grape->equals(Grape::create($name)));
        $this->assertFalse($grape->equals(Grape::create('Malbec')));
    }
}
