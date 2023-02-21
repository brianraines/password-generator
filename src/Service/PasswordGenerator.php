<?php

namespace App\Service;

use Symfony\Component\Finder\Finder;

class PasswordGenerator
{
    private $finder;
    private $wordLength = 5;
    private $wordCount = 3;
    private $numberCount = 3;
    private $symbolCount = 1;
    private $numbers = '0123456789';
    private $symbols = '~!@#$%^&*()_+=-';
    private $wordBank = [];
    private $usedWords = [];

    public function __construct($wordLength, $wordCount, $numberCount, $symbolCount)
    {
        $this->wordLength = $wordLength;
        $this->wordCount = $wordCount;
        $this->symbolCount = $symbolCount;
        $this->loadWordBank();
    }

    private function loadWordBank()
    {
        $finder = new Finder();
        $files = $finder->files()->in(__DIR__ . '/../Words/')->name('*.txt');
        foreach ($files as $file) {
            $candidates = explode("\n", $file->getContents());
            if (count($candidates) > 0) {
                $words = array_filter(
                    $candidates,
                    function ($value) {
                        return (strlen($value) == $this->wordLength
                        && in_array(strtolower(substr($value, 0, 1)), ['o', 'l', 'i']) !== true
                        && in_array(strtolower(substr($value, -1, 1)), ['o', 'l', 'i']) !== true
                        );
                    }
                );
                if (count($words) > 0) {
                    $this->wordBank = array_merge($this->wordBank, $words);
                }
            }
        }
    }

    public function generate(int $passwordCount = 1): array
    {
        $passwords = [];
        for ($i = 0; $i < $passwordCount; $i++) {
            $passwords[] = $this->generatePassword();
        }

        return $passwords;
    }

    private function generatePassword(): string
    {
        // get array of words based on count and length
        $words = $this->getWords();

        // get array of numbers based on count
        $numbers = $this->getNumbers();

        // get symbol
        $symbols = $this->getSymbols();

        return ((count($symbols) == 3) ? $symbols[2] : '')
            . $words
            . ((count($symbols) >= 1) ? $symbols[0] : '')
            . $numbers
            . ((count($symbols) >= 2) ? $symbols[1] : '');
    }

    private function getWords(): string
    {
        $words = [];

        $attempts = 0;

        while ($attempts < ($this->wordCount * 3) && count($words) < $this->wordCount) {
            $attempts++;

            $word = $this->wordBank[rand(0, (count($this->wordBank) - 1))];
            if (in_array(ucwords(strtolower($word)), $words) !== true && in_array(strtolower($word), $this->usedWords) !== true) {
                $words[] = ucwords(strtolower($word));
                $this->usedWords[] = strtolower($word);
            }
        }

        return implode("", $words);
    }

    private function getNumbers(): string
    {
        $numbers = [];

        while (count($numbers) < $this->numberCount) {
            $number = $this->getNumber();
            $duplicates = array_count_values($numbers);
            $hasDuplicate = false;

            foreach ($duplicates as $num => $count) {
                if ($num == $number) {
                    $hasDuplicate = true;

                    if ($count < ($this->numberCount - 1)) {
                        $numbers[] = $number;
                    }
                }
            }

            if ($hasDuplicate === false) {
                $numbers[] = $number;
            }
        }
        return implode("", $numbers);
    }

    private function getNumber(): string
    {
        return substr($this->numbers, rand(0, (strlen($this->numbers) - 1)), 1);
    }

    private function getSymbols(): array
    {
        $symbols = [];

        while (count($symbols) < $this->symbolCount) {
            $symbol = $this->getSymbol();
            if (in_array($symbol, $symbols) !== true) {
                $symbols[] = $symbol;
            }
        }

        return $symbols;
    }

    private function getSymbol(): string
    {
        return substr($this->symbols, rand(0, (strlen($this->symbols) - 1)), 1);
    }
}
