<?php

namespace GC\Storage\Utility;

use GC\Container;

/**
 * Zbior funkcji pomagających operować na rekordach które przynależą do jakiejś grupy
 * Dla prawidłowego działania wymaga w klasie pochodnej:
 * public static $table = "";
 * public static $primary = "";
 * public static $joinTable = "";
 * public static $joinForeign = "";
 */
trait JoinTrait
{
    /**
     * Pobiera rekordy połączone z tabelką $joinTable po warunku $column = $foreign_id
     */
     public static function joinAllWithKeyByForeign($foreign_id)
     {
         $sql = self::sql("SELECT * FROM ::table LEFT JOIN ::joinTable AS p USING (::primary) WHERE p.::joinForeign = ? ORDER BY position ASC");
         $rows = Container::get('database')->fetchByKey($sql, [intval($foreign_id)], static::$primary);

         return $rows;
     }

     /**
      * Pobiera rekordy połączone z tabelką ::frames i połączone z tabelką $joinTable po warunku $column = $foreign_id
      */
     public static function joinAllWithFrameByForeign($foreign_id)
     {
         $sql = self::sql("SELECT * FROM ::table LEFT JOIN ::frames USING (frame_id) LEFT JOIN ::joinTable AS p USING (::primary) WHERE p.::joinForeign = ? ORDER BY position ASC");
         $rows = Container::get('database')->fetchByKey($sql, [intval($foreign_id)], static::$primary);

         return $rows;
     }

     /**
      * Usuń wszystkie rekordy dla klucza obcego równego $frame_id
      */
     protected static function deleteAllByForeign($foreign_id)
     {
         $sql = self::sql("DELETE rows FROM ::table AS rows LEFT JOIN ::joinTable AS p USING (::primary) WHERE p.::joinForeign = ?");
         $affectedRows = Container::get('database')->execute($sql, [intval($foreign_id)]);

         return $affectedRows;
     }

     /**
      * Usuwa rekordy, które nie posiadają przynależności do innej tabelki
      */
     protected static function deleteUnassignedByForeign()
     {
         $sql = self::sql("DELETE rows FROM ::table AS rows LEFT JOIN ::joinTable AS p USING(::primary) WHERE p.::joinForeign IS NULL");
         $affectedRows = Container::get('database')->execute($sql);

         return $affectedRows;
     }
}
