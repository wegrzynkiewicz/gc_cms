<?php

namespace GC\Auth;

use GC\Data;
use RuntimeException;

class Client
{
     /**
      * Zwraca kod jezyka, aktualnie uzywanego przez klienta
      */
     public static function getLang()
     {
         if (isset($_SESSION['lang']['routing'])) {
             return $_SESSION['lang']['routing'];
         }

         if (isset($_SESSION['lang']['staff'])) {
             return $_SESSION['lang']['staff'];
         }

         return Data::get('config')['lang']['clientDefault'];
     }
}
