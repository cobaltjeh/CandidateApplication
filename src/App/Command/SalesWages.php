<?php

declare(strict_types = 1);

namespace App\Command;

use App\Classes\PaymentDateCalculator;
use App\Logger\LoggerAwareTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class SalesWages
 *
 * @author Jan de Wit <cobaltjeh@gmail.com>
 */
class SalesWages extends AbstractCommand
{
    use LoggerAwareTrait;

    /**
     * @var PaymentDateCalculator
     */
    private $paymentDateCalculator;

    /**
     * SalesWages constructor.
     *
     * @param PaymentDateCalculator $paymentDateCalculator
     */
    public function __construct(PaymentDateCalculator $paymentDateCalculator)
    {
        $this->paymentDateCalculator = $paymentDateCalculator;

        parent::__construct();
    }

    /**
     * Configure the command
     */
    protected function configure() : void
    {
        parent::configure();

        $this->setDescription('Calculate dates for sales team wages payout.');
        $this->addArgument('output', InputArgument::REQUIRED, 'The output filename');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->onStarted();

        $outputFileName = (string) $input->getArgument('output');

        $this->debug(sprintf('The output filename is: %s', $outputFileName));

        $continueExport = true;

        // Do not overwrite by default, this is dumb, would be better to only allow writes in a certain export directory
        if (true === file_exists($outputFileName)) {
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion('The file you have selected already exists, continue with this action?', false);

            if (!$helper->ask($input, $output, $question)) {
                $continueExport = false;
            }
        }

        if (true === $continueExport) {
            $this->exportData($outputFileName);
        }

        $this->onShutdown();
    }

    /**
     * @param string $outputFileName
     */
    private function exportData(string $outputFileName): void
    {
        // Usage of generator will help memory usage when handling large result sets. For this case it isn't required
        $generator = function () {
            $startDate = (int) date('n');

            for ($i = $startDate; $i <= 12; $i++) {
                yield $this->paymentDateCalculator->calculateMonth($i);
            }
        };

        // Open csv for writing, and create header
        $fp = fopen($outputFileName, 'w');
        fputcsv($fp, ['Month Name', 'Salary Payment Date', 'Bonus Payment Date']);

        foreach ($generator() as $date) {
            $this->debug(sprintf('%s, %s, %s' . PHP_EOL, $date[0], $date[1], $date[2]));

            fputcsv($fp, $date);
        }

        fclose($fp);
    }
}
