<?php

return new Phalcon\Config([
	'production' => true,
	'display_errors' => 'off',
	'error_reporting' => E_ALL | ~E_NOTICE | ~E_STRICT,
	'mail_exceptions' => false,

	'timezone'   => 'Europe/Moscow',

	'database'   => array(
		"host"     => "localhost",
		"username" => "root",
		"password" => "",
		"dbname"   => "ss",
		"charset"  => "utf8",
	),

	'logger_messages' => DOCROOT . '../log/messages.log',
	'logger_email'    => DOCROOT . '../log/messages.log',
	'logger_cron'     => DOCROOT . '../log/messages.log',

	'metadata_cache_dir' => DOCROOT . '../app/cache/metadata/',
	'memcached_addr' => '172.17.42.1',
	'cache_dir' => DOCROOT . '../app/cache/',

	'admin' => [ 'rj28@ya.ru' ],

	'mailer' => '\\Rj\\MailerLog',

	'smtp_hostname'       => '127.0.0.1',
	'mailer_sender_name'  => 'robot',
	'mailer_sender_email' => 'noreply@localhost',
]);
