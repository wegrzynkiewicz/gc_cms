<?php

# sesja pracownika jest sprawdzana
$session = new GC\Auth\StaffSession();
GC\Data::set('session', $session);

// # stworzenie i weryfikacja tokenu CSRF
// $tokenCSRF = new GC\Auth\CSRFToken();
// GC\Data::set('tokenCSRF', $tokenCSRF);
