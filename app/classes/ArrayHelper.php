<?php

namespace GC;

class ArrayHelper
{
    /**
     * Tworzy nową tablice ze starymi kluczami, gdzie elementy tablicy
     * są przekazywany do $callback(), a zwracana wartość to nowy element tablicy
     */
    public static function rebuild(array $array, $callback)
    {
       $results = [];
       foreach ($array as $key => $value) {
           $results[$key] = $callback($value);
       }

       return $results;
    }

    /**
     * Dzieli tablice na $p równych tablic
     */
    public static function partition(array $array, $p)
    {
       $listlen = count($array);
       $partlen = floor($listlen / $p);
       $partrem = $listlen % $p;
       $partition = array();
       $mark = 0;
       for ($px = 0; $px < $p; $px++) {
           $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
           $partition[$px] = array_slice($array, $mark, $incr);
           $mark += $incr;
       }

       return $partition;
    }

    /**
     * Łączy wielowymiarową tablice w jedną tablicę
     */
    public static function unchunk($array)
    {
       return call_user_func_array('array_merge', $array);
    }

    /**
     * Pobiera element z tablicy $array po kluczach $keys, zwraca $default jeżeli nie znajdzie elementu
     * ArrayHelper::getValueByKeys($_POST, ['sample', 'example']) === $_POST['sample']['example'];
     */
    public static function getValueByKeys(array $array, array $keys, $default = null)
    {
       if (count($keys) == 0) {
           return $default;
       }

       foreach ($keys as $key) {
           if (!isset($array[$key])) {
               return $default;
           }
           $array = $array[$key];
       }

       return $array;
    }

    /**
     * Ustawia wartość $value elementu w tablicy $array po kluczach $keys,
     * zwraca $default jeżeli nie znajdzie elementu
     * ArrayHelper::setValueByKeys($_POST, ['sample', 'example'], 'value');
     * $_POST['sample']['example'] = 'value';
     */
    public static function setValueByKeys(array &$array, array $keys, $value)
    {
       if (count($keys) == 0) {
           return;
       }

       $lastKey = array_pop($keys);
       $arrayCurrent = &$array;

       foreach ($keys as $key) {
           if (!isset($arrayCurrent[$key])) {
               $arrayCurrent[$key] = [];
           }
           $arrayCurrent = &$arrayCurrent[$key];
       }

       $arrayCurrent[$lastKey] = $value;
    }
}
