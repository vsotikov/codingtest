<?php
declare(strict_types = 1);

namespace App\Machine;

/**
 * CoinCalculatorInterface
 *
 * @package App\Machine
 * @author Vitali Sotsikau <vsotikov@gmail.com>
 */
interface CoinCalculatorInterface
{
    /**
     * Calculate coins combination for given amount (in cents).
     * Returns the result in this format:
     *
     * Coin Count
     * ['0.01', '0'],
     * ['0.02', '0'],
     * .... .....
     *
     * @param int $amountCents
     * @return array
     */
    public function calculate(int $amountCents);
}