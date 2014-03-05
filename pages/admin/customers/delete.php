<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_GET['id'];
$message = '';
$data = array('id' => $id);
try {
	$db = new data_Base();
	$DBH = $db -> connect();

	$STH = $DBH -> prepare('DELETE FROM clients WHERE id = :id');
	$STH -> execute($data);

	header('location:list.php?message=' . $message);
} catch (PDOException $e) {
	echo 'ERROR: ' . $e -> getMessage();
}

header('location:list.php?message=' . $message);
?>
