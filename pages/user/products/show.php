<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('user/products/show.phtml');

$result = array();


try {
    $db = new data_Base();
    $DBH = $db->connect();

    $stmt = $DBH->prepare('SELECT * FROM products  WHERE id = :id');
    $stmt->execute(array('id' => $_GET['id']));
    $result = $stmt->fetch();

    $stmt2 = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
    $stmt2->execute(array('id' => $result['categories_id']));
    $cat = $stmt2->fetch();
    $result['category'] = $cat['name'];

    $stmt4 = $DBH->prepare('SELECT * FROM product_images WHERE products_id = :id');
    $stmt4->execute(array('id' => $result['id']));
    $imm = $stmt4->fetch();
    $result['image'] = $imm['path'];
	
	

    //mette il prezzo giusto
    $result['price'] = $result['retail_price'];
    if (isset($_SESSION['user']['price_range']))
        switch ($_SESSION['user']['price_range']) {
            case 1:
                $result['price'] = $result['wholesale_price'];
                break;
            case 2:
                $result['price'] = $result['retail_price'];
                break;
            case 3:
                $result['price'] = $result['super_price'];
                break;
        }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('prod' => $result));
?>
