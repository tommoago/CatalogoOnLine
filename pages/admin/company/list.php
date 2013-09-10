<?php
include '../../../classes/dataBase.php';
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
include '../../../classes/Session.php';
$session = new Session();
if(!$session->check_role('jack')){
   header('location:../index.php?message= Unauthorized access.'); 
}

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/*, array('cache' => '../../../templates/cache')*/);
$template = $twig->loadTemplate('admin/company/list.phtml');

$result = array();
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM company_info');
    $stmt->execute();
    $result = $stmt->fetchAll();

} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('data' => $result));
?>
