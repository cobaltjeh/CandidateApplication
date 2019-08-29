<?php

declare(strict_types = 1);

namespace App\Classes;

use InvalidArgumentException;

/**
 * Class PaymentDateCalculator
 *
 * @author Jan de Wit <cobaltjeh@gmail.com>
 */
class PaymentDateCalculator
{
    /**
     * @var int
     */
    private $defaultBonusDate;

    /**
     * PaymentDateCalculator constructor.
     *
     * @param int $defaultBonusDate
     */
    public function __construct(int $defaultBonusDate)
    {
        $this->defaultBonusDate = $defaultBonusDate;
    }

    /**
     * @param int      $month
     * @param int|null $year
     *
     * @return array
     */
    public function calculateMonth(int $month, int $year = null): array
    {
        if ($month < 1 || $month > 12) {
            throw new InvalidArgumentException(sprintf('Invalid range for month given: %s', $month));
        }

        if (null === $year) {
            $year = (int) date('Y');
        }

        // Start with generating the date of the 15th of the month
        $wednesday = new \DateTime();
        $wednesday->setDate($year, $month, $this->defaultBonusDate);

        // Check if the day is week/weekend day
        if (in_array((int) $wednesday->format("w"), [0, 6], true)) {
            // Calculate next Wednesday
            $wednesday->modify('next Wednesday');
        }

        $bonusPaymentDate = $wednesday->format('Y-m-d');

        // Calculate end of month day
        $wednesday->modify('last day of this month');

        // Check if the day is week/weekend day
        if (in_array((int) $wednesday->format("w"), [0, 6], true)) {
            // Calculate previous Friday
            $wednesday->modify('last Friday');
        }

        $salaryPaymentDate = $wednesday->format('Y-m-d');

        return [$wednesday->format('F'), $salaryPaymentDate, $bonusPaymentDate];
    }
}
