<?php

require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/*, array('cache' => '../../../templates/cache')*/);
$template = $twig->loadTemplate('admin/administrators/list.phtml');

$username = 'root';
$password = 'root';
$result = array();
$message = '';
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
    $stmt = $DBH->prepare('SELECT * FROM administrators');
    $stmt->execute();
    $result = $stmt->fetchAll();

} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('admins' => $result, 'message' => $message));
?>
