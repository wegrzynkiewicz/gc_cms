<?php

/**
 * Zbiór pomocniczych metod dla wszystkich (stron) posiadających rusztowanie
 *
 * Przez (stronę) w nawiasach rozumiemy np. (strony, strony produktu, artykuły, widgety, wpisy)
 * Innymi słowy wszystko co zawiera moduły, powinno używać tej cechy
 */
trait HasFrameModelTrait
{
    /**
     * Pobiera wszystkie (strony) z ich rusztowaniami
     */
    public static function selectAllFrames()
    {
        # pobierz wszystkie rusztowania dla (stron)
        $sql = self::sql("SELECT * FROM ::table AS b JOIN ::frames AS f USING(frame_id) ORDER BY f.name ASC");
        $rows = Database::fetchAllWithPrimaryId($sql, [], static::$primary);

        return $rows;
    }

    /**
     * Pobiera (stronę) razem z rusztowaniem
     */
    public static function selectFrameByPrimaryId($primary_id)
    {
        # pobierz dane rusztowania dla (strony) o id podstawowego
        $sql = self::sql("SELECT * FROM ::table AS b JOIN ::frames AS f USING(frame_id) WHERE ::primary = ? LIMIT 1");
        $row = Database::fetchSingle($sql, [$primary_id]);

        return $row;
    }

    /**
     * Usuwa (stronę), rusztowanie (strony) i moduły (strony)
     */
    protected static function deleteFrameByPrimaryId($primary_id)
    {
        $row = self::selectFrameByPrimaryId($primary_id);

        # usuń wszystkie moduły dla rusztowania o id podstawowego
        $sql = self::sql("DELETE m FROM gc_frame_modules AS m LEFT JOIN gc_frame_positions AS p USING (module_id) WHERE frame_id = ?");
        Database::execute($sql, [$row['frame_id']]);

        # usuń rusztowanie o id podstawowym (strony)
        $sql = self::sql("DELETE f FROM ::table AS b JOIN gc_frames AS f USING(frame_id) WHERE ::primary = ?");
        Database::execute($sql, [$primary_id]);

        # usuń (stronę) o id podstawowym
        self::deleteByPrimaryId($primary_id);

        return $row;
    }
}
