<?php

declare(strict_types = 1);

use CarInsurance\Calculator;
use CarInsurance\PolicyInput;
use CarInsurance\PremiumResolver;

require_once '../vendor/autoload.php';

header('Content-Type: application/json');

$totalValue = (int) ($_GET['total_value'] ?? 0);
$tax = (int) ($_GET['tax'] ?? 0);
$installments = (int) ($_GET['installments'] ?? 0);
$time = (int) ($_GET['time'] ?? time());
$time = new \DateTimeImmutable('@' . $time);

try {
    $calculator = new Calculator();

    http_response_code(200);

    echo json_encode($calculator->calculate(new PolicyInput(
        PremiumResolver::premiumByDate($time), $totalValue, $tax, $installments
    )));
} catch (\InvalidArgumentException $e) {
    http_response_code(422);
    echo json_encode(['error' => 'Invalid input', 'message' => $e->getMessage()]);
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Generally bad things', 'message' => $e->getMessage()]);
}
