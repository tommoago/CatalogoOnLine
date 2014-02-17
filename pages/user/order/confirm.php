<?php

include '../../../classes/Cart.php';
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$message = '';
if (!isset($_SESSION['user']['type'])) {
	$message = gettext('ord.must.usr');
	header('location:../../user/login.php?order=yes&message=' . $message);
	exit();
}

isset($_SESSION['cart']) ? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];

$a_id = $_POST['a_id'];
$data = array('data' => date("Y-m-d H:i:s"), 'cus_id' => $_SESSION['user']['id'], 'a_id' => $a_id);

try {
	$db = new data_Base();
	$DBH = $db -> connect();

	$stmt = $DBH -> prepare('INSERT INTO orders(data, customers_id, addresses_id)
                                VALUES(:data, :cus_id, :a_id)');
	$stmt -> execute($data);

	$ord_id = $DBH -> lastInsertId();
	foreach ($cart->getProducts() as $row) {
		$stmt2 = $DBH -> prepare('INSERT INTO orders_has_products (orders_id, products_id, quantity, sold_price)
                                                        VALUES(:ord_id, :prod_id, :qty, :sold_price)');

		$stmt2 -> execute(array('ord_id' => $ord_id, 'prod_id' => $row['id'], 'qty' => $row['qty'], 'sold_price' => $row['price']));
	}
	$message = gettext('ord.conf.usr');

	$cart -> emptyCart();

	header('location:../../user/orders/list.php?message=' . $message);
} catch (PDOException $e) {
	echo 'ERROR: ' . $e -> getMessage();
}
?>
