<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig -> loadTemplate('user/categories/list.phtml');

$result = array();
$message = isset($_GET['message']) ? $_GET['message'] : '';
try {
	$db = new data_Base();
	$DBH = $db -> connect();

	$stmt = $DBH -> prepare('SELECT categories.* FROM categories,products WHERE categories.id=products.categories_id AND products.catalog_id=' . $_GET['id_catl'] . ' GROUP BY categories.id ');
	$stmt -> execute();
	$result = $stmt -> fetchAll();

} catch (PDOException $e) {
	echo 'ERROR: ' . $e -> getMessage();
}

$template -> display(array('cats' => $result, 'message' => $message));
?>
