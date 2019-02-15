<?php

namespace CarInsurance;

final class Policy implements \JsonSerializable
{
    /**
     * @var Installment[]
     */
    private $installments;
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
    /**
     * @var PolicyInput
     */
    private $input;

    public function __construct(PolicyInput $input, float $premiumTotal, float $commissionTotal, float $taxTotal, float $totalCost, array $installments)
    {
        foreach ($installments as $installment) {
            if (! $installment instanceof Installment) {
                throw new \InvalidArgumentException('Unknown class for Installment');
            }
        }

        $this->premiumTotal = $premiumTotal;
        $this->commissionTotal = $commissionTotal;
        $this->taxTotal = $taxTotal;
        $this->totalCost = $totalCost;
        $this->installments = $installments;
        $this->input = $input;
    }

    /**
     * @return Installment[]
     */
    public function installments(): array
    {
        return $this->installments;
    }

    public function premiumTotal(): float
    {
        return $this->premiumTotal;
    }

    public function commissionTotal(): float
    {
        return $this->commissionTotal;
    }

    public function taxTotal(): float
    {
        return $this->taxTotal;
    }

    public function totalCost(): float
    {
        return $this->totalCost;
    }

    public function jsonSerialize(): array
    {
        return [
            'policy' => $this->input,
            'premiumTotal' => sprintf('%0.2f', $this->premiumTotal),
            'commissionTotal' => sprintf('%0.2f', $this->commissionTotal),
            'taxTotal' => sprintf('%0.2f', $this->taxTotal),
            'totalCost' => sprintf('%0.2f', $this->totalCost),
            'installments' => $this->installments,
        ];
    }
}
