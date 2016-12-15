<?php

namespace GC\Storage\Utility;

use GC\Model\Frame;
use GC\Model\FrameModule;
use GC\Storage\Database;

/**
 * Zbiór pomocniczych metod dla wszystkich (stron) posiadających rusztowanie
 *
 * Przez (stronę) w nawiasach rozumiemy np. (strony, strony produktu, artykuły, widgety, wpisy)
 * Innymi słowy wszystko co zawiera moduły, powinno używać tej cechy
 */
trait ContainFrameTrait
{
    /**
     * Pobiera wszystkie (strony) z ich rusztowaniami
     */
    public static function selectAllWithFrames()
    {
        # pobierz wszystkie rusztowania dla (stron)
        $sql = self::sql("SELECT * FROM ::table AS b JOIN ::frames AS f USING(frame_id) WHERE ::lang ORDER BY f.name ASC");
        $rows = Database::fetchAllWithKey($sql, [], static::$primary);

        return $rows;
    }

    /**
     * Pobiera (stronę) razem z rusztowaniem
     */
    public static function selectWithFrameByPrimaryId($primary_id)
    {
        # pobierz dane rusztowania dla (strony) o id podstawowego
        $sql = self::sql("SELECT * FROM ::table AS b JOIN ::frames AS f USING(frame_id) WHERE ::primary = ? LIMIT 1");
        $row = Database::fetchSingle($sql, [intval($primary_id)]);

        return $row;
    }

    /**
     * Usuwa (stronę), rusztowanie (strony) i moduły (strony)
     */
    protected static function deleteFrameByPrimaryId($primary_id)
    {
        # pobierz informacje o rusztowaniu o id głownym
        $row = static::selectWithFrameByPrimaryId($primary_id);

        # usuń wszystkie moduły dla rusztowania o frame_id
        FrameModule::deleteAllByFrameId($row['frame_id']);

        # usuń rusztowanie o id głownym (strony)
        Frame::deleteByPrimaryId($row['frame_id']);

        # usuń (stronę) o id głownym
        static::deleteByPrimaryId($primary_id);
    }
}
