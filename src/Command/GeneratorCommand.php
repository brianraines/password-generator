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
            ->addOption('word-count', 'w', InputOption::VALUE_REQUIRED, 'Word Count[1-10]', 3)
            ->addOption('word-length', 'l', InputOption::VALUE_REQUIRED, 'Word Length [3-9]', 4)
            ->addOption('number-count', 'b', InputOption::VALUE_REQUIRED, 'Number Count [1-20]', 3)
            ->addOption('symbol-count', 's', InputOption::VALUE_REQUIRED, 'Symbol Count [1-3]', 1)
            ->addOption('password-count', 'p', InputOption::VALUE_REQUIRED, 'Password Count [1-100]', 10)
            ->addOption('acronym', 'a', InputOption::VALUE_REQUIRED, 'Acronym (Max length: 10)', '')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $numberCount = (int) $input->getOption('number-count');
        $symbolCount = (int) $input->getOption('symbol-count');
        $wordCount = (int) $input->getOption('word-count');
        $wordLength = (int) $input->getOption('word-length');
        $passwordCount = (int) $input->getOption('password-count');
        $acronym = $input->getOption('acronym');

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
        if ($this->areArgumentsValid($acronym, $wordLength, $wordCount, $numberCount, $symbolCount, $passwordCount, $output) !== true) {
            return Command::INVALID;
        }

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        $generator = new PasswordGenerator($wordLength, $wordCount, $numberCount, $symbolCount, $acronym);
        $output->writeln($generator->generate($passwordCount));

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;
    }

    private function areArgumentsValid($acronym, $wordLength, $wordCount, $numberCount, $symbolCount, $passwordCount, OutputInterface $output): bool
    {
        $valid = true;

        if (strlen($acronym) > 10) {
            $output->writeln('<error>Acronym is too long!! Max length is 10.</error>');
            $valid = false;
        }

        if ($numberCount < 1 || $numberCount > 20) {
            $output->writeln('<error>Invalid number count!! Must be between 1-20.</error>');
            $valid = false;
        }

        if ($symbolCount < 1 || $symbolCount > 3) {
            $output->writeln('<error>Invalid symbol count!! Must be between 1-3.</error>');
            $valid = false;
        }

        if ($wordCount < 1 || $wordCount > 10) {
            $output->writeln('<error>Invalid word count!! Must be between 1-10.</error>');
            $valid = false;
        }

        if ($wordLength < 3 || $wordLength > 9) {
            $output->writeln('<error>Invalid word length!! Must be between 3-9.</error>');
            $valid = false;
        }

        if ($passwordCount < 1 || $passwordCount > 100) {
            $output->writeln('<error>Invalid password count!! Must be between 1-100.</error>');
            $valid = false;
        }

        return $valid;
    }
}
