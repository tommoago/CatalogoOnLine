<?php
include '../../../conf/config.php';
include '../../../classes/imgUploader.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_POST['id'];
$name = $_POST['name'];

try {
	$db = new data_Base();
	$DBH = $db -> connect();

	$data = array('name' => $name, 'id' => $id);

	$STH = $DBH -> prepare('UPDATE catalog SET  
                            name = :name
                          WHERE id = :id');
	$STH -> execute($data);

	header('location:show.php?id=' . $id);
} catch (PDOException $e) {
	echo 'ERROR: ' . $e -> getMessage();
}
?>
