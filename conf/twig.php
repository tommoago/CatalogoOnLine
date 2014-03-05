<?php

//set twig default options, including the i18n support
require_once $_SERVER["DOCUMENT_ROOT"] .'/catalogoonline/vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();
require_once $_SERVER["DOCUMENT_ROOT"] .'/catalogoonline/vendor/twig/extensions/lib/Twig/Extensions/Autoloader.php';
Twig_Extensions_Autoloader::register();

$loader = new Twig_Loader_Filesystem($_SERVER["DOCUMENT_ROOT"] .'/catalogoonline/templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$twig->addExtension(new Twig_Extensions_Extension_I18n());
?>
