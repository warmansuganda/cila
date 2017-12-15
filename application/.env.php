<?php

	define('ENVIRONMENT', 'development');

	switch (ENVIRONMENT) {
		case 'development':
			define('APP_DOMAIN', 'http://localhost/php/bijb-finance');
			define('ENCRYPTION_KEY', '8kkUuxs9TkNECqedT1bMo0xTrlcoZket');
			define('SESS_COOKIE_NAME', 'ci_accounting_session');
			define('CSRF_TOKEN_NAME', 'csrf_token');
			define('CSRF_COOKIE_NAME', 'csrf_cookie');

			// Database Setting
			define('DB_DBDRIVER', 'mysqli');
			define('DB_HOSTNAME', 'localhost');
			define('DB_USERNAME', 'root');
			define('DB_PASSWORD', 'subangmaju');
			define('DB_DATABASE', 'bijb_finance');

			break;
		
		default:
			# code...
			break;
	}
