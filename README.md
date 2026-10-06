# Bawiarenka

Strona [bawiarenka.com](https://bawiarenka.com/) - kameralna bawialnia dla dzieci, Witebska 2/u3, Warszawa.

Statyczny `index.html` (bez builda) oraz skrypty PHP w `api/`:

- `mail.php` - formularz rezerwacji urodzin (mail do bawiarenka@gmail.com i potwierdzenie dla klienta)
- `s.php`, `t.php`, `e.php` - sesje, czas w sekcjach i zdarzenia, zapisywane w Postgres (Supabase) z kolumną `domain`

## Wdrożenie

Wgraj zawartość repozytorium na serwer (PHP 8.2+ z rozszerzeniem `pgsql`) i wpisz hasło do bazy w `api/helpers/.user.ini` w miejsce `<PASSWORD>`.
