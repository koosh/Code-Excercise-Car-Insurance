<?php

namespace CarInsurance;

final class Calculator
{
    public function calculate(PolicyInput $input): Policy
    {
        $premiumTotal = $input->totalValue() * $input->premium()->premium();
        $commissionTotal = $premiumTotal * $input->premium()->commission();
        $taxTotal = $premiumTotal * $input->tax();

        $totalCost = $premiumTotal + $commissionTotal + $taxTotal;

        $installmentsNumber = $input->installments();

        $installment = [
            'premiums' => $this->allocateEqually($premiumTotal, $installmentsNumber),
            'commissions' => $this->allocateEqually($commissionTotal, $installmentsNumber),
            'taxes' => $this->allocateEqually($taxTotal, $installmentsNumber),
            'totalCosts' => $this->allocateEqually($totalCost, $installmentsNumber),
        ];

        $installments = [];
        for ($i = 0; $i < $installmentsNumber; $i++) {
            $installments[] = new Installment(
                $installment['premiums'][$i],
                $installment['commissions'][$i],
                $installment['taxes'][$i],
                $installment['totalCosts'][$i]
            );
        }

        return new Policy($input, $premiumTotal, $commissionTotal, $taxTotal, $totalCost, $installments);
    }

    private function allocateEqually(float $total, int $divisor): array
    {
        $total = round($total, 2);

        $splits = array_fill(1, $divisor, round($total / $divisor, 2));
        $splitsTotal = $splits[1] * $divisor;

        $difference = abs(round($splitsTotal - $total, 2));

        // walk back in the splits adjusting the split value by 0.01 until the splits equal to total
        $index = $divisor;
        while ($difference > 0) {
            $index = $index > 0 ? $index : $divisor;
            $difference -= 0.01;
            $splits[$index--] += $splitsTotal < $total ? 0.01 : -0.01;
        }

        return array_values($splits);
    }
}
