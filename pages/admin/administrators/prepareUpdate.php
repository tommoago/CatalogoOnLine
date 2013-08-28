<?php

require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/*, array('cache' => '../../../templates/cache')*/);
$template = $twig->loadTemplate('admin/administrators/update.phtml');

$username = 'root';
$password = 'root';
$id = $_GET['id'];

try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);

    $stmt = $DBH->prepare('SELECT * FROM administrators WHERE id = :id');
    $stmt->execute(array('id' => $id));
    //tira fuori solo un risultato
    $admin = $stmt->fetch();
  
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('admin' => $admin));
?>
