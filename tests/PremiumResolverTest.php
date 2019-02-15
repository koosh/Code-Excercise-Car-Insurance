<?php

use CarInsurance\PremiumResolver;

class PremiumResolverTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @param DateTimeInterface $time
     * @param float $expected
     * @dataProvider premiumByDateProvider
     */
    public function testResolveByDate(DateTimeInterface $time, float $expected)
    {
        $premium = PremiumResolver::premiumByDate($time);

        $this->assertEquals($expected, $premium->premium());
    }

    public function premiumByDateProvider(): array
    {
        return [
            'thursday before 15' => [
                'time' => new \DateTimeImmutable('2019-02-14 14:00'),
                'expected' => 0.11,
            ],
            'thursday after 15' => [
                'time' => new \DateTimeImmutable('2019-02-14 16:00'),
                'expected' => 0.11,
            ],
            'friday before 14' => [
                'time' => new \DateTimeImmutable('2019-02-15 14:00'),
                'expected' => 0.11,
            ],
            'friday at 15' => [
                'time' => new \DateTimeImmutable('2019-02-15 15:00'),
                'expected' => 0.13,
            ],
            'friday between 15 - 20' => [
                'time' => new \DateTimeImmutable('2019-02-15 16:00'),
                'expected' => 0.13,
            ],
            'friday at 20' => [
                'time' => new \DateTimeImmutable('2019-02-15 20:00'),
                'expected' => 0.11,
            ],
            'friday after 20' => [
                'time' => new \DateTimeImmutable('2019-02-15 21:00'),
                'expected' => 0.11,
            ],
        ];
    }
}
