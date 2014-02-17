<?php

include '../../conf/config.php';
include '../../classes/Session.php';

$email = $_POST['email'];
$passwd = $_POST['password'];
$message = '';

try {
	$db = new data_Base();
	$DBH = $db -> connect();
	$data = array('email' => $email, 'password' => md5($passwd));
	$STH = $DBH -> prepare('SELECT * FROM customers WHERE email = :email AND password = :password AND active = 1');
	$STH -> execute($data);
	$result = $STH -> fetch();

	if (!empty($result)) {
		$_SESSION['user'] = $result;
		/* //qualora esista un ordi ne non confermato ne carico l'id in sessione;
		 $stmt3 = $DBH->prepare('SELECT * FROM orders  WHERE customers_id = :id AND data= (SELECT MAX(orders.data) FROM orders)');
		 $stmt3->execute(array('id' => $result['id']));
		 $oldOrd = $stmt3->fetch();
		 if (!empty($oldOrd))
		 $_SESSION['user']['oldOrd'] = $oldOrd['id'];
		 if ($_POST['order'] != '') {
		 header('location:../site/order/summary.php');
		 exit;
		 }*/
		header('location:index.php');
	} else {
		$message = gettext('invalid.cred'); ;
		header('location:login.php?message=' . $message);
	}
} catch (PDOException $e) {
	echo 'ERROR: ' . $e -> getMessage();
}
?>
