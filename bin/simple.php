#!/usr/bin/env php72
<?php

declare(strict_types = 1);

use \App\Classes\PaymentDateCalculator;

require_once __DIR__ . '/../vendor/autoload.php';

if (!isset($argv[1])) {
    exit('Missing output file parameter');
}

$generator = function () {
    $startDate = (int) date('n');
    $paymentDateCalculator = new PaymentDateCalculator(15);

    for ($i = $startDate; $i <= 12; $i++) {
        yield $paymentDateCalculator->calculateMonth($i);
    }
};

// Open csv for writing, and create header
$fp = fopen($argv[1], 'w');
fputcsv($fp, ['Month Name', 'Salary Payment Date', 'Bonus Payment Date']);

foreach ($generator() as $date) {
    echo sprintf('%s, %s, %s' . PHP_EOL, $date[0], $date[1], $date[2]);

    fputcsv($fp, $date);
}

fclose($fp);
