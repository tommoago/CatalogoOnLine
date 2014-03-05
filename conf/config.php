<?php

session_start();
// I18N support information here
$language =  isset($_SESSION['lang'])? $_SESSION['lang']: 'it_IT';
$_SESSION['lang'] = $language;

putenv('LANG='.$language); 
setlocale(LC_ALL, $language);

require_once($_SERVER["DOCUMENT_ROOT"] .'/catalogoonline/pages/gettext.inc');

// gettext setup
T_setlocale(LC_MESSAGES, $locale);
// Set the text domain as 'default'
$domain = 'default';
T_bindtextdomain($domain, $_SERVER["DOCUMENT_ROOT"] .'/catalogoonline/locale');
T_bind_textdomain_codeset($domain, 'UTF-8');
T_textdomain($domain);

include $_SERVER["DOCUMENT_ROOT"] .'/catalogoonline/classes/data_Base.php';

?>
