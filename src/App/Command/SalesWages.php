<?php

declare(strict_types = 1);

namespace App\Command;

use App\Logger\LoggerAwareTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class SalesWages
 *
 * @author Jan de Wit <cobaltjeh@gmail.com>
 */
class SalesWages extends AbstractCommand
{
    use LoggerAwareTrait;

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

        $this->onShutdown();
    }
}
