<?php
/**
 * THIS IS A MANUALLY CREATED FILE AND NEEDS TO BE MANUALLY UPDATED
 *
 * When composer dump-autoload is called autoload_files.php is not generated for some reason, this file manually includes the files from autoload_files.php
 *
 * TODO: look into why autoload_files.php is not generated
 *
 */

$vendorDir = __DIR__;

$load_files = array(
	'7b11c4dc42b3b3023073cb14e519683c' => $vendorDir . '/ralouphie/getallheaders/src/getallheaders.php',
	'e69f7f6ee287b969198c3c9d6777bd38' => $vendorDir . '/symfony/polyfill-intl-normalizer/bootstrap.php',
	'c964ee0ededf28c96ebd9db5099ef910' => $vendorDir . '/guzzlehttp/promises/src/functions_include.php',
	'a0edc8309cc5e1d60e3047b5df6b7052' => $vendorDir . '/guzzlehttp/psr7/src/functions_include.php',
	'f598d06aa772fa33d905e87be6398fb1' => $vendorDir . '/symfony/polyfill-intl-idn/bootstrap.php',
	'37a3dc5111fe8f707ab4c132ef1dbc62' => $vendorDir . '/guzzlehttp/guzzle/src/functions_include.php',
);

foreach ( $load_files as $load_file ) {
	require $load_file;
}

include __DIR__ . '/autoload.php';