<?php

namespace GC\Translation;

class NullTranslator
{
    public function translate($text, array $params = [])
    {
        return vsprintf($text, $params);
    }
}
