# password-generator
Script that generates passwords


Password Requirements:
	• each word is:
		• Unique (meaning different words in the password)
		• N letters long
		• Capitalized, the first letter of the word in uppercase, and the rest of the letters in lowercase. like “Tree”
		• cannot start or end with the letter “O”, “L” or “i"
	• numbers:
		• each random number can repeat in the set, but can only repeat once
			• 369, 633, 363 and 336 are all okay
			• 333 is not okay
	• 1-3 special character of ~!@#$%^&*()_+=-


    Usage:
        app:generate-password [options]

    Options:
        -w, --word-count=WORD-COUNT          Word Count [default: 3]
        -l, --word-length=WORD-LENGTH        Word Length [default: 4]
        -b, --number-count=NUMBER-COUNT      Number Count [default: 3]
        -s, --symbol-count=SYMBOL-COUNT      Symbol Count [default: 1]
        -p, --password-count=PASSWORD-COUNT  Password Count [default: 10]
        -h, --help                           Display help for the given command. When no command is given display help for the list command
        -q, --quiet                          Do not output any message
        -V, --version                        Display this application version
            --ansi|--no-ansi                 Force (or disable --no-ansi) ANSI output
        -n, --no-interaction                 Do not ask any interactive question
        -e, --env=ENV                        The Environment name. [default: "dev"]
            --no-debug                       Switch off debug mode.
        -v|vv|vvv, --verbose                 Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug


Example output: TreeMarsExit=428