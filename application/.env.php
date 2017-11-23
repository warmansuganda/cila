<?php

	define('ENVIRONMENT', 'development');

	switch (ENVIRONMENT) {
		case 'development':
			define('APP_DOMAIN', 'http://localhost/php/bijb-finance');
			break;
		
		default:
			# code...
			break;
	}
