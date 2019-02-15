<?php

namespace CarInsurance;

final class PolicyInput implements \JsonSerializable
{
    /**
     * @var int
     */
    private $tax;
    /**
     * @var int
     */
    private $installments;
    /**
     * @var int
     */
    private $totalValue;
    /**
     * @var Premium
     */
    private $premium;

    public function __construct(Premium $premium, int $totalValue, int $tax, int $installments)
    {
        if (!($tax > 0 && $tax <= 100)) {
            throw new \InvalidArgumentException('Tax is not within 1...100');
        }

        if (!($installments > 0 && $installments <= 12)) {
            throw new \InvalidArgumentException('Installments is not within 1...12');
        }

        if (!($totalValue >= 100 && $totalValue <= 100000)) {
            throw new \InvalidArgumentException('Total value is not within 100...100000');
        }

        $this->tax = $tax / 100;
        $this->installments = $installments;
        $this->totalValue = $totalValue;
        $this->premium = $premium;
    }

    public function premium(): Premium
    {
        return $this->premium;
    }

    public function tax(): float
    {
        return $this->tax;
    }

    public function installments(): int
    {
        return $this->installments;
    }

    public function totalValue(): int
    {
        return $this->totalValue;
    }

    public function jsonSerialize(): array
    {
        return [
            'premium' => $this->premium,
            'tax' => sprintf('%0.2f', $this->tax),
            'total_value' => sprintf('%0.2f', $this->totalValue),
            'installments' => $this->installments,
        ];
    }
}
