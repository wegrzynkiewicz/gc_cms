# SECURE #
* Używanie PDO
* Hasła hashowane za pomocą password_hash()
* Usunięcie nagłówka X-Powered-By
* Użycie nagłówka X-Frame-Options: Deny - _Zabrania na wyświetlenie w ramce_
* Użycie nagłówka X-Content-Type-Options: nosniff - _Zabrania zgadywania typu MIME_
* Użycie nagłówka X-XSS-Protection: 1; mode=block - _Chroni przed XSS_
* Nadanie session.cookie_httponly = 1, flaga HttpOnly
* Generowanie unikatowego tokena CSRF za każdym żądaniem

# TODO #
* Usuwanie przestarzałych kopii zapasowych
* ~~Dorobić ustawienia wiersza w modułach~~
* Nadać wszystkim funkcjonalnością odpowiednie uprawnienia
* Dodać krótki tekst pomocniczy dla każdej funkcjonalności
* Dodać więcej typów pól w formularzu
* Dodać walidację danych
