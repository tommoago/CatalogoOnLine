<?php

session_start();
// I18N support information here
$language = $_SESSION['lang'] = $_GET['lang'];
putenv('LANG='.$language); 
setlocale(LC_ALL, $language);

header('location:' . $_SERVER['HTTP_REFERER']);

?>
