<?php

namespace GC;

/**
 * elFinder Plugin Normalizer
 *
 *	$opts = array(
 *		'bind' => array(
 *			'upload.pre mkdir.pre mkfile.pre rename.pre archive.pre ls.pre' => array(
 *				'Plugin.Normalizer.cmdPreprocess'
 *			),
 *			'upload.presave' => array(
 *				'Plugin.Normalizer.onUpLoadPreSave'
 *			)
 *		),
 *	);
 */
class Normalizer
{
    private $keyMap = array(
        'ls' => 'intersect',
        'upload' => 'renames'
    );

    public function cmdPreprocess($cmd, &$args, $elfinder, $volume)
    {
        $key = (isset($this->keyMap[$cmd]))? $this->keyMap[$cmd] : 'name';

        if (isset($args[$key])) {
            if (is_array($args[$key])) {
                foreach ($args[$key] as $i => $name) {
                    $args[$key][$i] = $this->normalize($name);
                }
            } else {
                $args[$key] = $this->normalize($args[$key]);
            }
        }

        return true;
    }

    public function onUpLoadPreSave(&$path, &$name, $src, $elfinder, $volume)
    {
        if ($path) {
            $path = $this->normalize($path);
        }
        $name = $this->normalize($name);

        return true;
    }

    public function normalize($unformatted)
    {
        return normalize($unformatted);
    }
}
