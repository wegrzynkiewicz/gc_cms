<?php

declare(strict_types=1);

namespace GC\Model\PopUp;

use GC\Storage\AbstractModel;

class Display extends AbstractModel
{
    public static $table = '::popup_display';

    public static function updateFrames($popup_id, array $frames)
    {
        # usuń wszystkie przynależności stron do okienek
        static::delete()
            ->equals('popup_id', $popup_id)
            ->execute();

        # wstaw przynależność wyświetlania na zadanej podstronie
        foreach ($frames as $frame_id) {
            static::insert([
                'popup_id' => $popup_id,
                'frame_id' => $frame_id,
            ]);
        }
    }
}
