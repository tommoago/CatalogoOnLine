<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig -> loadTemplate('admin/catalog/update.phtml');

$id = $_GET['id'];
$result = array();

try {
	$db = new data_Base();
	$DBH = $db -> connect();

	$stmt3 = $DBH -> prepare('SELECT * FROM catalog WHERE id = :id');
	$stmt3 -> execute(array('id' => $_GET['id']));
	$cat = $stmt3 -> fetch();
} catch (PDOException $e) {
	echo 'ERROR: ' . $e -> getMessage();
}

$template -> display(array('cat' => $cat, 'message' => isset($_GET['message']) ? $_GET['message'] : ''));
