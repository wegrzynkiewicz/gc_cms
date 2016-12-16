SECURE
* Używanie PDO
* Hasła hashowane za pomocą password_hash()
* Usunięcie nagłówka X-Powered-By
* Użycie nagłówka X-Frame-Options: Deny _Zabrania na wyświetlenie w ramce_
* Użycie nagłówka X-Content-Type-Options: nosniff _Zabrania na zgadywanie typu MIME_
* Użycie nagłówka X-XSS-Protection: 1; mode=block _Chroni przed XSS_
* Nadanie session.cookie_httponly = 1, flaga HttpOnly
* Codzienna zmiana nazwy ciastka sesyjnego
* Zastosowanie Subresource Integrity dla zewnętrznych zależności
* Generowanie unikatowego tokena CSRF w obrębie sesji
