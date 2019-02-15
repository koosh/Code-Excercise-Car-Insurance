<?php

use CarInsurance\Calculator;
use CarInsurance\PolicyInput;
use CarInsurance\Premium;

class CalculatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @param PolicyInput $input
     * @param array $expected
     * @dataProvider calculationInputs
     */
    public function testCalculation(PolicyInput $input, array $expected)
    {
        $calculator = new Calculator();
        $policy = $calculator->calculate($input);

        $this->assertEquals($expected['totalCost'], $policy->totalCost());
        $this->assertEquals($expected['premiumTotal'], $policy->premiumTotal());
        $this->assertEquals($expected['commissionTotal'], $policy->commissionTotal());
        $this->assertEquals($expected['taxTotal'], $policy->taxTotal());

        $this->assertEquals(count($expected['installments']), count($policy->installments()));
        foreach ($policy->installments() as $key => $installment) {
            $this->assertEquals($expected['installments'][$key]['totalCost'], $installment->totalCost());
            $this->assertEquals($expected['installments'][$key]['premiumTotal'], $installment->premiumTotal());
            $this->assertEquals($expected['installments'][$key]['commissionTotal'], $installment->commissionTotal());
            $this->assertEquals($expected['installments'][$key]['taxTotal'], $installment->taxTotal());
        }
    }

    public function calculationInputs(): array
    {
        return [
            'provided' => [
                'input' => new PolicyInput(new Premium(11, 17), 10000, 10, 2),
                'expected' => [
                    'totalCost' => 1397,
                    'premiumTotal' => 1100,
                    'commissionTotal' => 187,
                    'taxTotal' => 110,
                    'installments' => [
                        [
                            'totalCost' => 698.50,
                            'premiumTotal' => 550,
                            'commissionTotal' => 93.50,
                            'taxTotal' => 55,
                        ],
                        [
                            'totalCost' => 698.50,
                            'premiumTotal' => 550,
                            'commissionTotal' => 93.50,
                            'taxTotal' => 55,
                        ],
                    ],
                ],
            ],
            'minimum' => [
                'input' => new PolicyInput(new Premium(11, 17), 100, 10, 2),
                'expected' => [
                    'totalCost' => 13.97,
                    'premiumTotal' => 11.00,
                    'commissionTotal' => 1.87,
                    'taxTotal' => 1.10,
                    'installments' => [
                        [
                            'totalCost' => 6.99,
                            'premiumTotal' => 5.5,
                            'commissionTotal' => 0.94,
                            'taxTotal' => 0.55,
                        ],
                        [
                            'totalCost' => 6.98,
                            'premiumTotal' => 5.5,
                            'commissionTotal' => 0.93,
                            'taxTotal' => 0.55,
                        ],
                    ],
                ],
            ],
            'split to three' => [
                'input' => new PolicyInput(new Premium(10, 10), 1000, 10, 3),
                'expected' => [
                    'totalCost' => 120,
                    'premiumTotal' => 100,
                    'commissionTotal' => 10,
                    'taxTotal' => 10,
                    'installments' => [
                        [
                            'totalCost' => 40,
                            'premiumTotal' => 33.33,
                            'commissionTotal' => 3.33,
                            'taxTotal' => 3.33,
                        ],
                        [
                            'totalCost' => 40,
                            'premiumTotal' => 33.33,
                            'commissionTotal' => 3.33,
                            'taxTotal' => 3.33,
                        ],
                        [
                            'totalCost' => 40,
                            'premiumTotal' => 33.34,
                            'commissionTotal' => 3.34,
                            'taxTotal' => 3.34,
                        ],
                    ],
                ],
            ],
        ];
    }
}
