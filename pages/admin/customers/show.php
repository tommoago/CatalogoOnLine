<?php

require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/*, array('cache' => '../../../templates/cache',)*/);
$template = $twig->loadTemplate('admin/customers/show.phtml');

$username = 'root';
$password = 'root';

$id = $_GET['id'];
$result = array();

try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
    $stmt = $DBH->prepare('SELECT * FROM customers WHERE id = :id');
    $stmt->execute(array('id' => $id));
    $customer = $stmt->fetch();
    
    $stmt2 = $DBH->prepare('SELECT * FROM administrators WHERE id = :id');
    $stmt2->execute(array('id' => $customer['administrators_id']));
    $adm = $stmt2->fetch();
    $customer['oprerator'] = $adm['user'];
    
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('cus' => $customer));
?>
