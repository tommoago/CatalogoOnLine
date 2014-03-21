<?php
include '../../../classes/Cart.php';
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig -> loadTemplate('user/cart/list.phtml');

isset($_SESSION['cart']) ? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];

$result = array();

try {
	$db = new data_Base();
	$DBH = $db -> connect();

	foreach ($cart->getCurrentProducts() as $row) {
		$stmt = $DBH -> prepare('SELECT * FROM products  WHERE id = :id');
		$stmt -> execute(array('id' => $row['id']));
		$product = $stmt -> fetch();
		$product['qty'] = $row['qty'];

		if (strlen($row['description']) > 150)
			$product['description'] = substr($product['description'], 0, 150) . '...';

		//mette il prezzo giusto
		$product['price'] = $row['discount_price'];


		$stmt2 = $DBH -> prepare('SELECT * FROM categories WHERE id = :id');
		$stmt2 -> execute(array('id' => $product['categories_id']));
		$cat = $stmt2 -> fetch();
		$product['category'] = $cat['name'];

		$result[] = $product;
	}
} catch (PDOException $e) {
	echo 'ERROR: ' . $e -> getMessage();
}
$splitted = explode('/', $_SERVER['HTTP_REFERER']);
$template -> display(array('prods' => $result, 'tot' => $cart -> getTot()));
?>
