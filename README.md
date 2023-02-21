# password-generator
Script that generates passwords


Password Requirements:
	• 3 words, where each word is:
		• Unique (meaning three different words)
		• 4 letters long
		• Capitalized, the first letter of the word in uppercase, and the rest of the letters in lowercase. like “Tree”
		• cannot start or end with the letter “O”, “L” or “i"
	• 3 numbers
		• each random number can repeat in the set of three, but can only repeat once
			• 369, 633, 363 and 336 are all okay 
			• 333 is not okay
	• 1 special character of ~!@#$%^&*()_+=-

Concatenated as:
[rand-word-1][rand-word-2][rand-word-3][rand-num-1][rand-num-2][rand-num-3][1-special-character]

Example output: TreeMarsExit428=