<?php

declare(strict_types=1);

namespace AppBundle\Tests\Service;

use App\Bundle\WineBundle\Service\WineLabelService;
use App\Domain\Grape\Grape;
use App\Domain\Wine\Wine;
use PHPUnit\Framework\TestCase;

class WineLabelServiceTest extends TestCase
{
    /**
     * @var WineLabelService
     */
    protected $labelService;

    /**
     * set up.
     */
    public function setUp()
    {
        $this->labelService = new WineLabelService();
    }

    /**
     * data provider for generate label successful cases.
     *
     * @return array
     */
    public function generateLabelSuccessDataProvider()
    {
        $cabernetSauvignon = Grape::create('Cabernet Sauvignon');
        $cabernetFranc = Grape::create('Cabernet Franc');
        $merlot = Grape::create('Merlot');
        $malbec = Grape::create('Malbec');

        return [
            [
                [
                    [$cabernetSauvignon, 80], [$cabernetFranc, 20],
                ],
                'Cabernet Sauvignon, Cabernet Franc',
            ],
            [
                [
                    [$cabernetSauvignon, 80], [$merlot, 10], [$malbec, 10],
                ],
                'Cabernet Sauvignon, Malbec, Merlot',
            ],
            [
                [
                    [$cabernetSauvignon, 80], [$malbec, 15], [$merlot, 5],
                ],
                'Cabernet Sauvignon, Malbec, Merlot',
            ],
        ];
    }

    /**
     * test generation of label.
     *
     * @param array $grapeList
     * @dataProvider generateLabelSuccessDataProvider
     */
    public function testGenerateGrapesLabel($grapeList, $result)
    {
        $wine = new Wine();
        foreach ($grapeList as $grapeSet) {
            $wine->addGrape($grapeSet[0], $grapeSet[1]);
        }

        $label = $this->labelService->generateGrapesLabel($wine);

        self::assertSame($result, $label);
    }
}
