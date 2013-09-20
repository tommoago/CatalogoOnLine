<?php
include '../../../classes/dataBase.php';
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
include '../../../classes/Session.php';
$session = new Session();

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/*, array('cache' => '../../../templates/cache',)*/);
$template = $twig->loadTemplate('admin/products/insert.phtml');

$result = array();

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM categories');
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    $stmt = $DBH->prepare('SELECT * FROM suppliers');
    $stmt->execute();
    $result2 = $stmt->fetchAll();
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('cats' => $result, 'supps' => $result2, 'message' => isset($_GET['message'])? $_GET['message'] :''));
?>
