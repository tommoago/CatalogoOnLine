<?php
include '../../../../conf/config.php';
include '../../../../classes/imgUploader.php';
include '../../../../classes/Session.php';
$session = new Session();

$name = $_POST['name'];

try {
	$db = new data_Base();
	$DBH = $db -> connect();
	$data = array('name' => $name, 'id' => $_SESSION['user']['id']);

	$STH = $DBH -> prepare('INSERT INTO catalog (name, customers_id) value (:name, :id)');

	//customers_id = :id
	$STH -> execute($data);
	$idProd = $DBH -> lastInsertId();

	header('location:show.php?id=' . $idProd);
} catch (PDOException $e) {
	echo 'ERROR: ' . $e -> getMessage();
}
?>
