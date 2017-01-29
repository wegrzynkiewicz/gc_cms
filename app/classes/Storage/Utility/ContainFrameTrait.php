<?php

namespace GC\Storage\Utility;

use GC\Assert;
use GC\Model\Module\Frame;
use GC\Model\Module\Module;
use GC\Data;
use GC\Auth\Staff;

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
    public static function selectWithFrames()
    {
        return static::select()
            ->source('::table JOIN ::frames USING(frame_id)')
            ->equals('lang', Staff::getEditorLang())
            ->order('name', 'ASC');
    }

    /**
     * Pobiera wszystkie (strony) z ich rusztowaniami i zapisuje jako tablice primary_id => $column
     */
    public static function mapFramesWithPrimaryKeyBy($column)
    {
        Assert::column($column);
        $sql = self::sql("SELECT ::primary, {$column} FROM ::table AS b JOIN ::frames AS f USING(frame_id) WHERE ::lang ORDER BY f.name ASC");
        $map = Database::getInstance()->fetchByMap($sql, [], static::$primary, $column);

        return $map;
    }

    /**
     * Pobiera (stronę) razem z rusztowaniem
     */
    public static function selectWithFrameByPrimaryId($primary_id)
    {
        # pobierz dane rusztowania dla (strony) o id podstawowego
        $sql = self::sql("SELECT * FROM ::table AS b JOIN ::frames AS f USING(frame_id) WHERE ::primary = ? LIMIT 1");
        $row = Database::getInstance()->fetch($sql, [intval($primary_id)]);

        return $row;
    }

    /**
     * Usuwa (stronę), rusztowanie (strony) i moduły (strony)
     */
    public static function deleteFrameByPrimaryId($primary_id)
    {
        # pobierz informacje o rusztowaniu o id głownym
        $row = static::selectWithFrameByPrimaryId($primary_id);

        # usuń wszystkie moduły dla rusztowania o frame_id
        Module::deleteModulesByForeign($row['frame_id']);

        # usuń wszystkie moduły, które nie są przypisane do rusztowań
        Module::deleteUnassignedByForeign();

        # usuń rusztowanie o id głownym (strony)
        Frame::deleteByPrimaryId($row['frame_id']);

        # usuń (stronę) o id głownym
        static::deleteByPrimaryId($primary_id);
    }
}
