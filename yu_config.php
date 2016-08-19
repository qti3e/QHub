<?php
/**
 *  This is sample config file you should put your own values and
 * rename it to yu_config.php
 * Search for special configs with hashtags!
 * @license GPL 3
 * @author QTI3E
 */

/*
 * Configurations for database
 * #db
 */
/**
 * Constant `db_driver`
 *  It's for setting your database driver for making connections.
 *  1. mysqli
 *  2. pdo
 *  3. redis
 */
define('db_driver','redis');
/**
 * Constant `db_host`
 *  It's address of place that your database is located.
 */
define('db_host','127.0.0.1');
/**
 * Constant `port`
 *  Your database port
 *  Default values:
 *      MySQL   3306
 *      Redis   6379
 */
define('db_port',6379);
/**
 * Constant `db_name`
 * Your database name
 *  In redis it's a integer value between 0-255 and default value for redis is 0
 */
define('db_name',15);
/**
 * Constant `db_user`
 * Database username
 * Put it empty in redis :)
 */
define('db_user','');
/**
 * Constant `db_pass`
 * Database password
 */
define('db_pass',null);
/**
 * Constant `db_charset`
 * Character encoding
 */
define('db_charset','utf8');
/*
 * General configurations
 * #general
 */
/**
 * Constant `base_url`
 * Insert your website base url here
 */
define('base_url','');
/**
 * Framework language
 * Note: It's not your site language and it's only language of Youn framework, errors and system variables
 *          will shown in this language
 * Note: If you want to change it check if your language is exists in core/i18n/langs/ with following format
 *          core/i18n/langs/{%language code}.php
 * How to contribute?
 *      If you want to translate this framework to your own language copy english file and rename it to your
 *  language name after that start to translate that file.
 *  Note: Don't translate keys of array
 */
define('lang','en');

/**
 * Default mailer library sender address.
 */
define('mail_from','noreplay@example.com');

/**
 * Default name of mailer sender
 */
define('mail_from_name','Noreplay');
//todo: set crypto_key to an null string and make an internal error if it's empty
/**
 * Crypto special key
 * Change it!
 */
define('crypto_key','fqGycWCD1)Af$sD77qbGuavERu1VKnxLwBV(7a2xr4gSD56jSZv@RY0kXDL)S-4XXk+lX-p%$o)1e^ufM60$b+rM#kH%9IyFkPHaYS8eVs)I@X&XPKqOS%^LoMLHlNb85RcK7!N@N(f@3dY$2!$9uF0iWMYWUq@!Kr3QcZCvOrx#6eP0c7W3gSTAqj-JqP7JALRwEmAyZnZK(0PlIDPucDWq*CE&(L$4zEOW&uIa)3n3q)0saSQGg9914t_+7feW');