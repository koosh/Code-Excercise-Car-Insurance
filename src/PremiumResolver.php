<?php

namespace CarInsurance;

final class PremiumResolver
{
    static public function premiumByDate(\DateTimeInterface $time): Premium
    {
        $premium = 11;
        if ($time->format('w') == '5'
            && $time->format('H') > 14
            && $time->format('H') < 20
        ) {
            $premium = 13;
        }

        $commission = 17;

        return new Premium($premium, $commission);
    }
}
