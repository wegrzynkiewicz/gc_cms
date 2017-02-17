<?php

require ACTIONS_PATH.'/root/_import.php';

error_reporting(0);
restore_error_handler();

function adminer_object()
{
    class AdminerSoftware extends Adminer
    {
        public function credentials()
        {
            return array('localhost', 'root', 'root');
        }

        public function database()
        {
            return '_gc_cms';
        }
    }

    return new AdminerSoftware();
}

$_GET['username'] = '';

require ROOT_PATH.'/vendor/adminer-4.2.5-mysql-pl.php';
