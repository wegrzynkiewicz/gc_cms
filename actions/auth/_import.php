<?php

# sesja pracownika jest tylko odczytywana, nie jest sprawdzana czy jest zalogowany
GC\Auth\Staff::startSession();

# stworzenie i weryfikacja tokenu CSRF
$tokenCSRF = new GC\Auth\CSRFToken();
GC\Data::set('tokenCSRF', $tokenCSRF);
