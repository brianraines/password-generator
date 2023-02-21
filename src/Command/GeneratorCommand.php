<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\PasswordGenerator;

#[AsCommand(name: 'app:generate-password')]
class GeneratorCommand extends Command
{
    protected function configure(): void
    {
        $this
            // ...
            ->addOption('word-count', 'w', InputOption::VALUE_REQUIRED, 'Word Count[1-10]', 3)
            ->addOption('word-length', 'l', InputOption::VALUE_REQUIRED, 'Word Length [3-9]', 5)
            ->addOption('number-count', 'b', InputOption::VALUE_REQUIRED, 'Number Count [1-20]', 3)
            ->addOption('symbol-count', 's', InputOption::VALUE_REQUIRED, 'Symbol Count [1-3]', 1)
            ->addOption('password-count', 'p', InputOption::VALUE_REQUIRED, 'Password Count [1-1000]', 10)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $invalid = false;
        // validate input
        $numberCount = (int) $input->getOption('number-count');
        if ($numberCount < 1 || $numberCount > 20) {
            $output->writeln('<error>Invalid number count!! Must be between 1-20.</error>');
            $invalid = true;
        }

        $symbolCount = (int) $input->getOption('symbol-count');
        if ($symbolCount < 1 || $symbolCount > 3) {
            $output->writeln('<error>Invalid symbol count!! Must be between 1-3.</error>');
            $invalid = true;
        }

        $wordCount = (int) $input->getOption('word-count');
        if ($wordCount < 1 || $wordCount > 10) {
            $output->writeln('<error>Invalid word count!! Must be between 1-10.</error>');
            $invalid = true;
        }

        $wordLength = (int) $input->getOption('word-length');
        if ($wordLength < 3 || $wordLength > 9) {
            $output->writeln('<error>Invalid word length!! Must be between 3-9.</error>');
            $invalid = true;
        }

        $passwordCount = (int) $input->getOption('password-count');
        if ($passwordCount < 1 || $passwordCount > 1000) {
            $output->writeln('<error>Invalid password count!! Must be between 1-1000.</error>');
            $invalid = true;
        }

        if ($invalid === true) {
            return Command::INVALID;
        }

        $generator = new PasswordGenerator($wordLength, $wordCount, $numberCount, $symbolCount);

        $output->writeln($generator->generate($passwordCount));

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}
