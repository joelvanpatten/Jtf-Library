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