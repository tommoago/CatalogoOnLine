<?php
session_start();
include '../classes/dataBase.php';
require_once '../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../templates/cache') */);
$template = $twig->loadTemplate('menu.phtml');

$result = array();
try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM categories WHERE categories_id IS NULL');
    $stmt->execute();

    $result = $stmt->fetchAll();

    foreach ($result as &$row) {
        $stmt = $DBH->prepare('SELECT * FROM categories WHERE categories_id = :id');
        $stmt->execute(array('id' => $row['id']));
        $stmt->execute();
        $row['category'] = '';
        $row['category'] = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
//print_r($result);
echo json_encode($result);
//$template->display(array('cats' => $result));
?>
