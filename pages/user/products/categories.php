<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();



try {
	$db = new data_Base();
	$DBH = $db -> connect();

	$stmt = $DBH -> prepare('SELECT categories.* FROM categories,products WHERE categories.id=products.categories_id AND products.catalog_id=' . $_GET['id'] . ' GROUP BY categories.id ');
	$stmt -> execute();
	$result = $stmt -> fetchAll();

} catch (PDOException $e) {
	echo 'ERROR: ' . $e -> getMessage();
}

echo json_encode($result);
?>
