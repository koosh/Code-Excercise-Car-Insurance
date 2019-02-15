<?php

namespace CarInsurance;

final class Installment implements \JsonSerializable
{
    /**
     * @var float
     */
    private $premiumTotal;
    /**
     * @var float
     */
    private $commissionTotal;
    /**
     * @var float
     */
    private $taxTotal;
    /**
     * @var float
     */
    private $totalCost;

    public function __construct(float $premiumTotal, float $commissionTotal, float $taxTotal, float $totalCost)
    {
        $this->premiumTotal = $premiumTotal;
        $this->commissionTotal = $commissionTotal;
        $this->taxTotal = $taxTotal;
        $this->totalCost = $totalCost;
    }

    /**
     * @return float
     */
    public function premiumTotal(): float
    {
        return $this->premiumTotal;
    }

    /**
     * @return float
     */
    public function commissionTotal(): float
    {
        return $this->commissionTotal;
    }

    /**
     * @return float
     */
    public function taxTotal(): float
    {
        return $this->taxTotal;
    }

    /**
     * @return float
     */
    public function totalCost(): float
    {
        return $this->totalCost;
    }

    public function jsonSerialize(): array
    {
        return [
            'premiumTotal' => sprintf('%0.2f', $this->premiumTotal),
            'commissionTotal' => sprintf('%0.2f', $this->commissionTotal),
            'taxTotal' => sprintf('%0.2f', $this->taxTotal),
            'totalCost' => sprintf('%0.2f', $this->totalCost),
        ];
    }
}
