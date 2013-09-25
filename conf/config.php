<?php

session_start();
// I18N support information here
$language = 'en';
putenv("LANG=$language"); 
setlocale(LC_ALL, $language);

// Set the text domain as 'default'
$domain = 'default';
bindtextdomain($domain, "locale"); 
textdomain($domain);

include $_SERVER["DOCUMENT_ROOT"] .'/melarossa/classes/dataBase.php';


?>
