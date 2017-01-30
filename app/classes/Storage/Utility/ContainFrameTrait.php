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
