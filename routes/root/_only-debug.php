<?php

# panel roota jest dostępny tylko jeżeli jest włączony debug
if (!$config['debug']['enabled']) {
    displayError(403);
    die();
}
