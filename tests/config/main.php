<?php
define('BASE_PATH',  realpath(dirname(__FILE__) . '/../../'));
define('TESTS_PATH', realpath(BASE_PATH         . '/tests'));
define('LIB_PATH',   realpath(TESTS_PATH        . '/library'));
define('TESTS_LIB',  realpath(LIB_PATH          . '/KissTest'));

set_include_path(BASE_PATH  . PATH_SEPARATOR . get_include_path());
set_include_path(TESTS_PATH . PATH_SEPARATOR . get_include_path());
set_include_path(LIB_PATH   . PATH_SEPARATOR . get_include_path());
set_include_path(TESTS_LIB  . PATH_SEPARATOR . get_include_path());

require_once('Jtf/AutoLoader.php');
Jtf_AutoLoader::registerAutoLoad();

/*
 * MySQL Test Database
 * 
 * user: jtf_test
 * pass: jtf_test
 * host: localhost
 * db:   jtf_test
 * port: 3306
 */

Jtf_PdoSingleton::setDbHost('localhost');
Jtf_PdoSingleton::setDbPort('3306');
Jtf_PdoSingleton::setDbUser('jtf_test');
Jtf_PdoSingleton::setDbPass('jtf_test');
Jtf_PdoSingleton::setDbName('jtf_test');

Jtf_PdoSingleton::getInstance()->exec('SET FOREIGN_KEY_CHECKS=0;');
Jtf_PdoSingleton::getInstance()->exec('TRUNCATE TABLE `gtwy_tests`');
Jtf_PdoSingleton::getInstance()->exec('TRUNCATE TABLE `join_tests`');
Jtf_PdoSingleton::getInstance()->exec('SET FOREIGN_KEY_CHECKS=1;');