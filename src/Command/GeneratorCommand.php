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
            ->addOption('word-count', 'w', InputOption::VALUE_REQUIRED, 'Word Count', 3)
            ->addOption('word-length', 'l', InputOption::VALUE_REQUIRED, 'Word Length', 4)
            ->addOption('number-count', 'b', InputOption::VALUE_REQUIRED, 'Number Count', 3)
            ->addOption('symbol-count', 's', InputOption::VALUE_REQUIRED, 'Symbol Count', 1)
            ->addOption('password-count', 'p', InputOption::VALUE_REQUIRED, 'Password Count', 10)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        // ... put here the code to create the user

        $generator = new PasswordGenerator($input->getOption('word-length'), $input->getOption('word-count'), $input->getOption('number-count'), $input->getOption('symbol-count'));

        $output->writeln($generator->generate($input->getOption('password-count')));

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
