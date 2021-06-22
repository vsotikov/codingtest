<?php
declare(strict_types = 1);

namespace App\Machine;

/**
 * PurchasedItem
 *
 * @package App\Machine
 * @author Vitali Sotsikau <vsotikov@gmail.com>
 */
class PurchasedItem implements PurchasedItemInterface
{
    private $itemQuantity;
    private $totalAmount;
    private $change;

    public function __construct(int $itemQuantity, float $totalAmount, array $change)
    {
        $this->itemQuantity = $itemQuantity;
        $this->totalAmount = $totalAmount;
        $this->change = $change;
    }

    public function getItemQuantity()
    {
        return $this->itemQuantity;
    }

    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    public function getChange()
    {
        return $this->change;
    }
}