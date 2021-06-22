<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    /**
     * @var CoinCalculatorInterface
     */
    private $coinsCalculator;

    /**
     * CigaretteMachine constructor.
     */
    public function __construct(CoinCalculatorInterface $coinsCalculator)
    {
        $this->coinsCalculator = $coinsCalculator;
    }

    /**
     * @inheritDoc
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        // Convert float numbers to integers to avoid floating point related errors.
        // Also we can use PHP built-in functions to work with floating numbers (like fmod)
        $paidAmountCents = (int)(round($purchaseTransaction->getPaidAmount(), 2) * 100);
        $itemPriceCents = (int)(round(self::ITEM_PRICE, 2) * 100);

        $requestedPacks = $purchaseTransaction->getItemQuantity();

        // Init output varianles
        $itemQuantity = 0;
        $spentAmount = 0;
        $change = $paidAmountCents;

        // Start calculation only when at least 1 pack is requested and paid
        // amount is grater then a cost of single pack and pack price is greater than 0.
        // In all other cases system will just return whole paid money back
        if ($requestedPacks > 0 &&
            $itemPriceCents > 0 &&
            $paidAmountCents >= $itemPriceCents
        ) {
            $maxItemQuantity = intdiv($paidAmountCents, $itemPriceCents);

            // Adjust bought items quantity to either requested or maximum available one
            $itemQuantity = min($requestedPacks, $maxItemQuantity);

            // Calc spent money
            $spentAmountCents = $itemQuantity * $itemPriceCents;
            $spentAmount = round($spentAmountCents / 100, 2);

            // Calc change
            $change = $paidAmountCents - $spentAmountCents;
        }

        $purchasedItem = new PurchasedItem(
            $itemQuantity,
            $spentAmount,
            // Here we can return initial paid amount as well in case "change" equals to "paidAmount" (so nohing bought).
            // But thus we don't know what coins/banknotes were used upon purchase (we have only total amount),
            // we just calculate coins combination that will be returned
            $this->coinsCalculator->calculate($change)
        );

        return $purchasedItem;
    }
}