<?php

$_SESSION['staff']['sessionTimeout'] = time() + GC\Container::get('config')['session']['staffTimeout'];
