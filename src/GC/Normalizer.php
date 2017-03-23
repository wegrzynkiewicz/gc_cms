<?php

declare(strict_types=1);

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
    public function cmdPreprocess($cmd, &$args, $elfinder, $volume)
    {
        if (isset($args['name'])) {
            $args['name'] = $this->normalize($args['name']);
        }

        return true;
    }

    public function onUpLoadPreSave(&$path, &$name, $src, $elfinder, $volume)
    {
        $name = $this->normalize($name);

        return true;
    }

    public function normalize($unformatted)
    {
        return normalize($unformatted);
    }
}
