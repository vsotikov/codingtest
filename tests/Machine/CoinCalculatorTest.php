<?php
declare(strict_types = 1);

namespace Machine;

use App\Machine\CoinCalculator;
use PHPUnit\Framework\TestCase;

/**
 * CoinCalculatorTest
 *
 * @package Machine
 * @author Vitali Sotsikau <vsotikov@gmail.com>
 */
class CoinCalculatorTest extends TestCase
{
    protected $coinCalculator;

    protected function setUp()
    {
        $this->coinCalculator = new CoinCalculator();
    }

    public function detectClosestCoinCandidateProvider()
    {
        return [
            [-50, 0], [-1, 0], [0, 0], [1, 1], [2, 2], [3, 2],
            [5, 5], [10, 10], [15, 10], [20, 20], [30, 20], [50, 50],
            [70, 50], [100, 100], [110, 100], [170, 100], [200, 200],
            [230, 200], [290, 200], [900, 200], [9000, 200],
        ];
    }

    public function calculateProvider()
    {
        return [
            [-50, []],
            [-1, []],
            [0, []],
            [1, [['0.01', 1]]],
            [2, [['0.02', 1]]],
            [3, [['0.02', 1], ['0.01', 1]]],
            [5, [['0.05', 1]]],
            [10, [['0.10', 1]]],
            [15, [['0.10', 1], ['0.05', 1]]],
            [20, [['0.20', 1]]],
            [30, [['0.20', 1], ['0.10', 1]]],
            [50, [['0.50', 1]]],
            [70, [['0.50', 1], ['0.20', 1]]],
            [100, [['1.00', 1]]],
            [110, [['1.00', 1], ['0.10', 1]]],
            [170, [['1.00', 1], ['0.50', 1], ['0.20', 1]]],
            [188, [['1.00', 1], ['0.50', 1], ['0.20', 1], ['0.10', 1], ['0.05', 1], ['0.02', 1], ['0.01', 1]]],
            [200, [['2.00', 1]]],
            [230, [['2.00', 1], ['0.20', 1], ['0.10', 1]]],
            [290, [['2.00', 1], ['0.50', 1], ['0.20', 2]]],
            [299, [['2.00', 1], ['0.50', 1], ['0.20', 2], ['0.05', 1], ['0.02', 2]]],
            [900, [['2.00', 4], ['1.00', 1]]],
            [9000, [['2.00', 45]]],
            [9003, [['2.00', 45], ['0.02', 1], ['0.01', 1]]],
        ];
    }

    /**
     * @dataProvider detectClosestCoinCandidateProvider
     */
    public function testDetectClosestCoinCandidate(int $amountCents, int $expected)
    {
        $this->assertEquals(
            $expected,
            $this->coinCalculator->detectClosestCoinCandidate($amountCents)
        );
    }

    /**
     * @dataProvider calculateProvider
     */
    public function testCalculate(int $amountCents, array $expected)
    {
        $this->assertEquals(
            $expected,
            $this->coinCalculator->calculate($amountCents)
        );
//        $this->assertArraySubset(
//            $expected,
//            $this->coinCalculator->calculate($amountCents),
//            true
//        );
    }
}
