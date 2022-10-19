<?php
$content = array();
include('functions.php');
include('../config/settings.php');


if($config['maintenance'] == true && !isset($_COOKIE['maintenance'])) {
  header('Location: mentenanta.php');
} else if(isset($_COOKIE['maintenance']) || $config['maintenance'] == false) {
  if (!isset($_GET['p'])) {
    $_GET['p'] = 'index';
  } elseif (substr($_GET['p'], -1) == '/') {
    $_GET['p'] .= 'index';
  } elseif (is_dir('templates/' . $_GET['p'])) {
    $_GET['p'] .= '/index';
  } 
  
  $template = 'templates/' . $_GET['p'] . '.php';
  
  if (file_exists($template)) {
    ob_start();
    include($template);
    $content['default'] = ob_get_contents();
    ob_end_clean();
  } else {
    header('HTTP/1.0 404 Not Found');
    include('404.html');
    die();
  }
  
  include('layouts/application.php');

}


