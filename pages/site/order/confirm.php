<?php
include '../../../classes/Cart.php';
include '../../../conf/config.php';

$message = '';
print_r($_SESSION['user']);
if(!isset($_SESSION['user']['type'])){
    $message = gettext('ord.must.usr');
    header('location:../../user/login.php?order=yes&message='.$message);
    exit();
}


isset($_SESSION['cart'])? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];

$data = array('data' => date("Y-m-d H:i:s"), 'confirmed' => 0, 'cus_id' => $_SESSION['user']['id']);

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('INSERT INTO orders(data, confirmed, customers_id)
                                VALUES(:data, :confirmed, :cus_id)');
    $stmt->execute($data);

    $ord_id = $DBH->lastInsertId();
    foreach ($cart->getProducts() as $row) {
        $stmt2 = $DBH->prepare('INSERT INTO orders_has_products (orders_id, products_id, quantity, sold_price)
                                                        VALUES(:ord_id, :prod_id, :qty, :sold_price)');

        $stmt2->execute(array('ord_id' => $ord_id, 'prod_id' => $row['id'], 'qty' => $row['qty'], 'sold_price' => $row['price'],));
    }
    
    $cart->emptyCart();
    
    $message = gettext('ord.conf.usr');
    header('location:../../user/orders/list.php?message='.$message);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

?>
