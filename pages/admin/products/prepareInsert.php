<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/products/insert.phtml');

$result = array();

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM categories');
    $stmt->execute();
    $result = $stmt->fetchAll();
	
	$stmt = $DBH->prepare('SELECT * FROM catalog');
    $stmt->execute();
    $result2 = $stmt->fetchAll();
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('cats' => $result,'catls' => $result2, 'message' => isset($_GET['message'])? $_GET['message'] :''));
?>
