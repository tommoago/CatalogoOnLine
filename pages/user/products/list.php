<?php

include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig -> loadTemplate('user/products/list.phtml');

$result = array();
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
$limit = 50;
$numPages = 0;
$catl_id = $_GET['catalog_id'];

try {
	$db = new data_Base();
	$DBH = $db -> connect();

	//seleziono eventuali sottocategoria a quella attuale
	/*$stmt = $DBH->prepare('SELECT * FROM categories WHERE categories_id = :id');
	 $stmt->execute(array('id' => $_GET['category_id']));
	 $otherCats = $stmt->fetchAll();*/

	$stmt2 = $DBH -> prepare('SELECT COUNT(*) FROM products WHERE categories_id = :id AND catalog_id = :id_catl');
	$stmt2 -> execute(array('id' => $_GET['category_id'], 'id_catl' => $catl_id));
	$totProd = $stmt2 -> fetch();
	$count = $totProd[0];
	$numPages += intval($count / $limit);
	if ($count % $limit != 0) {
		$numPages++;
	}
	if ($offset != 0)
		$offset *= $limit;

	$stmt3 = $DBH -> prepare('SELECT * FROM products  WHERE categories_id = :id AND catalog_id = :id_catl LIMIT ' . $offset . ', ' . $limit);
	$stmt3 -> execute(array('id' => $_GET['category_id'], 'id_catl' => $catl_id));
	$result = $stmt3 -> fetchAll();

	foreach ($result as &$row) {
		//categoria associata
		$stmt4 = $DBH -> prepare('SELECT * FROM categories WHERE id = :id');
		$stmt4 -> execute(array('id' => $row['categories_id']));
		$cat = $stmt4 -> fetch();
		$row['category'] = $cat['name'];

		if (strlen($row['description']) > 150)
			$row['description'] = substr($row['description'], 0, 150) . '...';

		$stmt5 = $DBH -> prepare('SELECT * FROM product_images WHERE products_id = :id');
		$stmt5 -> execute(array('id' => $row['id']));
		$imm = $stmt5 -> fetch();
		$row['image'] = $imm['path'];

		//mette il prezzo giusto
		$row['price'] = $row['retail_price'];
		if (isset($_SESSION['user']['price_range']))
			switch ($_SESSION['user']['price_range']) {
				case 1 :
					$row['price'] = $row['wholesale_price'];
					break;
				case 2 :
					$row['price'] = $row['retail_price'];
					break;
				case 3 :
					$row['price'] = $row['super_price'];
					break;
			}
	}
} catch (PDOException $e) {
	echo 'ERROR: ' . $e -> getMessage();
}

$div = $offset / $limit;
$lowRange = $div - 3;
$maxRange = $div < 3 ? 6 : $div + 3;

$template -> display(array('prods' => $result, 'totPages' => $numPages, 'lr' => $lowRange, 'mr' => $maxRange, 'id_cat' => $_GET['category_id'], /*'oCats' => $otherCats*/));
?>
