import random
import string

WORDS_FILE = 'words_alpha.txt'        # List of English words, one per line
SPECIAL_CHARS = list('~!@#$%^&*()_+=-')
AVOID_START_END = {'o', 'l', 'i'}

# Session-wide record of used words
used_words = set()

def load_words(n):
    """Load unique words of length n, capitalize first letter."""
    with open(WORDS_FILE) as f:
        words = set(
            w.strip().capitalize()
            for w in f
            if len(w.strip()) == n and w.strip().isalpha()
        )
    return list(words)

def pick_words(n_words, word_len, acronym=None):
    global used_words
    words_pool = set(load_words(word_len)) - used_words

    if acronym:
        if len(acronym) != n_words:
            raise ValueError("Acronym length must match the number of words.")
        selected = []
        for a in acronym:
            candidates = [
                w for w in words_pool
                if w.startswith(a.upper()) and w not in used_words
            ]
            if not candidates:
                raise ValueError(f"No unused words starting with {a.upper()} of length {word_len}.")
            choice = random.choice(candidates)
            selected.append(choice)
            used_words.add(choice)
        return selected
    else:
        # Select n unique words, none starting or ending with letters in AVOID_START_END
        candidates = [
            w for w in words_pool
            if w[0].lower() not in AVOID_START_END 
            and w[-1].lower() not in AVOID_START_END
        ]
        if len(candidates) < n_words:
            raise ValueError(f"Not enough unused words left to build a {n_words}-word password.")
        selected = random.sample(candidates, n_words)
        used_words.update(selected)
        return selected

def generate_numbers(n_digits):
    # Repeat only once: each digit max 2 times
    digits = []
    candidates = list(string.digits) * 2
    for _ in range(n_digits):
        d = random.choice(candidates)
        digits.append(d)
        candidates.remove(d)
    random.shuffle(digits)
    return ''.join(digits)

def generate_special_chars(n_special):
    return ''.join(random.choices(SPECIAL_CHARS, k=n_special))

def generate_password(
        n_words=3,
        n_letters=5,
        n_digits=6,
        n_special=2,
        acronym=None
    ):
    words = pick_words(n_words, n_letters, acronym)
    numbers = generate_numbers(n_digits)
    specials = generate_special_chars(n_special)
    password_core = ''.join(words) + numbers + specials
    password_list = list(password_core)
    random.shuffle(password_list)
    return ''.join(password_list)

# Example: Generate a list of 5 passwords
for i in range(5):
    try:
        print(
            generate_password(
                n_words=random.randint(1, 10),
                n_letters=4,                # For example, use 4 letter words
                n_digits=random.randint(1, 20),
                n_special=random.randint(1, 3),
                acronym=None                # Or e.g. 'Pal' for PondAgedLook
            )
        )
    except ValueError as e:
        print(f"Stopped: {e}")
        break