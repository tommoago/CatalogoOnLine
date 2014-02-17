<?php
include '../../../../conf/config.php';
include '../../../../classes/Session.php';
$session = new Session();

$id = $_GET['id'];

try {
	$db = new data_Base();
	$DBH = $db -> connect();

	$STH = $DBH -> prepare('DELETE FROM catalog WHERE id = :id');
	$STH -> execute(array('id' => $id));
	header('location:list.php');
} catch (PDOException $e) {
	echo 'ERROR: ' . $e -> getMessage();
}
?>
