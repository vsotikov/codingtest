<?php
declare(strict_types = 1);

namespace App\Machine;

/**
 * PurchaseTransaction
 *
 * @package App\Machine
 * @author Vitali Sotsikau <vsotikov@gmail.com>
 */
class PurchaseTransaction implements PurchaseTransactionInterface
{
    private $itemQuantity;
    private $paidAmount;

    public function __construct(int $itemQuantity, float $paidAmount)
    {
        $this->itemQuantity = $itemQuantity;
        $this->paidAmount = $paidAmount;
    }

    /**
     * @inheritDoc
     */
    public function getItemQuantity()
    {
        return $this->itemQuantity;
    }

    /**
     * @inheritDoc
     */
    public function getPaidAmount()
    {
        return $this->paidAmount;
    }
}