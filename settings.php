<?php
/*********************************
Setari path
*********************************/
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$config = array();


define('ROOT',$_SERVER['DOCUMENT_ROOT']."/");
define('DOC_ROOT',$_SERVER['DOCUMENT_ROOT']."/");
define('HOST','https://belaauto.ro/');

define('TEMP_BASE',$_SERVER['PHP_SELF']);

define('ADMIN_ROOT',DOC_ROOT . 'admin/');
define('ADMIN_URL',HOST . 'admin/');
define('LOGIN', ADMIN_URL . 'login.php');
/*********************************
Setari debug
*********************************/
define('DEBUG',1);	// Salvare query-uri
define('LOG',1);	// Salvare adaugare produse, utilizatori, comenzi
define('LOG_FOLDER', DOC_ROOT . 'logs/logs');
// Base URL
//
// Also update the RewriteBase at the bottom of the htaccess file if the site lives in a subdirectory
$config['base_url'] = '/';


$config['maintenance'] = false;

if(isset($_GET['mentenanta'])) {
	setcookie('maintenance',true,time()+3600*24*7);
}

// Google Analytics Web Property ID
//
// Ex. UA-XXXXX-X
$config['google_analytics_web_property_id'] = 'UA--1';

/**********************************
Incarcare clase - autoload
**********************************/
function __autoload($class){
	include_once __DIR__ . "/{$class}.php";
}

require_once "password.php";
session_start();

?>