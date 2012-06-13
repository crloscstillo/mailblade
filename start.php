<?php

/*
|--------------------------------------------------------------------------
| Mailblade Start file
|--------------------------------------------------------------------------
*/

Autoloader::map(array(
	'Mailblade' => __DIR__.'/libraries/mailblade.php',
	'SMTP'      => __DIR__.'/libraries/smtp.php',
));

Autoloader::directories('templates');