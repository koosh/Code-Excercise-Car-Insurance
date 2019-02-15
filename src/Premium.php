<?php

namespace CarInsurance;

final class Premium implements \JsonSerializable
{
    /**
     * @var int
     */
    private $premium;
    /**
     * @var int
     */
    private $commission;

    public function __construct(int $premium, int $commission)
    {
        if (!$this->isPercentage($premium)) {
            throw new \InvalidArgumentException('Base interest is not within 1...100');
        }

        if (!$this->isPercentage($commission)) {
            throw new \InvalidArgumentException('Commission is not within 1...100');
        }

        $this->premium = $premium / 100;
        $this->commission = $commission / 100;
    }

    public function premium(): float
    {
        return $this->premium;
    }

    public function commission(): float
    {
        return $this->commission;
    }

    public function jsonSerialize(): array
    {
        return [
            'premium' => sprintf('%0.2f', $this->premium),
            'commission' => sprintf('%0.2f', $this->commission),
        ];
    }

    private function isPercentage(int $i): bool
    {
        return ($i > 0 && $i <= 100);
    }
}
