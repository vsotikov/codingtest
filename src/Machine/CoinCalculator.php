<?php
declare(strict_types = 1);

namespace App\Machine;

/**
 * CoinCalculator
 *
 * @package App\Machine
 * @author Vitali Sotsikau <vsotikov@gmail.com>
 */
class CoinCalculator implements CoinCalculatorInterface
{
    /**
     * All possible coins in format <nominal cents> => <display name>
     *
     * @var array
     */
    private $coins = [
        1 => '0.01',
        2 => '0.02',
        5 => '0.05',
        10 => '0.10',
        20 => '0.20',
        50 => '0.50',
        100 => '1.00',
        200 => '2.00',
    ];

    /**
     * CoinCalculator constructor.
     */
    public function __construct()
    {
        // Perform coins sort descending one time for later calculations
        arsort($this->coins, SORT_NUMERIC);
    }

    /**
     * @inheritDoc
     */
    public function calculate(int $amountCents)
    {
        $result = [];

        while ($amountCents > 0) {
            $coinCandidate = $this->detectClosestCoinCandidate($amountCents);

            // Handle possible exceptional case when we couldn't detect coin candidate
            if ($coinCandidate === 0) {
                break;
            }

            $coinsQuantity = intdiv($amountCents, $coinCandidate);
            $amountCents -= $coinCandidate * $coinsQuantity;

            $result[] = [
                $this->coins[$coinCandidate],
                $coinsQuantity
            ];
        }

        return $result;
    }

    /**
     * Detect the biggest coint we can propose to use for given amount
     *
     * @param int $amountCents
     * @return int positive numeric value or 0
     */
    public function detectClosestCoinCandidate(int $amountCents)
    {
        $coinCandidate = 0;

        foreach (array_keys($this->coins) as $coin) {
            if ($amountCents >= $coin) {
                $coinCandidate = $coin;

                break;
            }
        }

        return $coinCandidate;
    }
}