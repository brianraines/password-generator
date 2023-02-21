# password-generator
Script that generates passwords

##System Requirements
- PHP & Composer `brew install composer`
- Then from the app root folder run `composer install` to grab packages.

##Password Requirements:
- each word is:
    - Unique (meaning different words in the password)
    - N letters long
    - Capitalized, the first letter of the word in uppercase, and the rest of the letters in lowercase, like `Tree`
    - If using an acronym, first letter of each word must spell out the acronym, like `PondAgedLook` for the acronym `Pal`
    - If not using an acronym, cannot start or end with the letter `O`, `L` or `i`
- numbers:
    - each random number can repeat in the set, but can only repeat once
        - `369`, `633`, `363` and `336` are all okay
        - `333` is not okay
- 1-3 special character of `~!@#$%^&*()_+=-`

```bash
    Usage:
        bin/console app:generate-password [options]

    Options:
        -w, --word-count=WORD-COUNT          Word Count[1-10] [default: 3]
        -l, --word-length=WORD-LENGTH        Word Length [3-9] [default: 4]
        -b, --number-count=NUMBER-COUNT      Number Count [1-20] [default: 3]
        -s, --symbol-count=SYMBOL-COUNT      Symbol Count [1-3] [default: 1]
        -p, --password-count=PASSWORD-COUNT  Password Count [1-1000] [default: 10]
        -a, --acronym=ACRONYM                Acronym (Max length: 10) [default: ""]
        -h, --help                           Display help for the given command. When no command is given display help for the list command
        -q, --quiet                          Do not output any message
        -V, --version                        Display this application version
            --ansi|--no-ansi                 Force (or disable --no-ansi) ANSI output
        -n, --no-interaction                 Do not ask any interactive question
        -e, --env=ENV                        The Environment name. [default: "dev"]
            --no-debug                       Switch off debug mode.
        -v|vv|vvv, --verbose                 Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```

Example default output: `TreeMarsExit=428`

If using an Acronym like `Pal`: `PondAgedLook$015`
