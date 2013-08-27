<?php

require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates/admin/products');
$twig = new Twig_Environment($loader /*,array('cache' => '../../../templates/cache',)*/);
$template = $twig->loadTemplate('show.phtml');

$username = 'root';
$password = 'root';

$id = $_GET['id'];
$result = array();

try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
    $stmt = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
    $stmt->execute(array('id' => $id));
    $stmt->execute();

    $result = $stmt->fetchAll();
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('cat' => $result));
?>
