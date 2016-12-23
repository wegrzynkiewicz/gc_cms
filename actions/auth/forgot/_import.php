<?php

if (isset($_SESSION['staff'])) {
    GC\Response::redirect('/admin');
}
