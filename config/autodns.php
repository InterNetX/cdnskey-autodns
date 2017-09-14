<?php

return array(
	'user' => env('AUTODNS_USER', ''),
	'context' => env('AUTODNS_CONTEXT', ''),
	'password' => env('AUTODNS_PASSWORD', ''),
	'replyto' => env('AUTODNS_REPLYTO', ''),
	'language' => env('AUTODNS_LANG', 'en'),
	'url' => env('AUTODNS_URL', 'https://gateway.autodns.com'),
	'registration' => env('AUTODNS_REGISTRATION', 'true'),
);

?>
