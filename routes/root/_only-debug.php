<?php

# panel roota jest dostępny tylko jeżeli jest włączony debug
if (!$config['debug']['enabled']) {
    echo renderError(403);
}
