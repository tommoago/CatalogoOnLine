<?php

session_start();
// I18N support information here
$language =  isset($_SESSION['lang'])? $_SESSION['lang']: 'en';
$_SESSION['lang'] = $language;

putenv('LANG='.$language); 
setlocale(LC_ALL, $language);

// Set the text domain as 'default'
$domain = 'default';
bindtextdomain($domain, $_SERVER["DOCUMENT_ROOT"] .'/melarossa/locale'); 
textdomain($domain);

include $_SERVER["DOCUMENT_ROOT"] .'/melarossa/classes/dataBase.php';

?>
