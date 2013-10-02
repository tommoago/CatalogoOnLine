<?php
include '../../../classes/Cart.php';
include '../../../conf/config.php';

isset($_SESSION['cart'])?  : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];

try {
    $db = new dataBase();
    $DBH = $db->connect();

        $stmt = $DBH->prepare('SELECT * FROM products  WHERE id = :id');
        $stmt->execute(array('id' => $_POST['id']));
        $product = $stmt->fetch();
        $product['qty'] = 1;
        if(isset($_POST['qty_add']) && $_POST['qty_add'] != '' && $_POST['qty_add'] != 0)
            $product['qty'] = $_POST['qty_add'];
            
        //mette il prezzo giusto
        $product['price'] = $product['retail_price'];
        if (isset($_SESSION['user']['price_range']))
            switch ($_SESSION['user']['price_range']) {
                case 1:
                    $product['price'] = $product['wholesale_price'];
                    break;
                case 3: 
                    $product['price'] = $product['super_price'];
                    break;
            }

        $stmt2 = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt2->execute(array('id' => $product['categories_id']));
        $cat = $stmt2->fetch();
        $product['category'] = $cat['name'];

} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$cart->addProduct(array('id' => $product['id'], 'price' => $product['price'], 'qty' => $product['qty']));

header('location:list.php');
?>
