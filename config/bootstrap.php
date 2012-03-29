<?php
use lithium\core\Libraries;

/**
 * Include libraries
 */

$libsPath = dirname(__DIR__) . '/_source/';
$spotPath = $libsPath . 'Spot';

Libraries::add('Spot', array(
	'path' => $spotPath . '/lib/Spot',
	'bootstrap' => false
));
