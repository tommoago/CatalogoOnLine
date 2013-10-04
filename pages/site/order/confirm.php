<?php

include '../../../classes/Cart.php';
include '../../../conf/config.php';

$message = '';
if (!isset($_SESSION['user']['type'])) {
    $message = gettext('ord.must.usr');
    header('location:../../user/login.php?order=yes&message=' . $message);
    exit();
}


isset($_SESSION['cart'])? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];

$a_id = $_POST['a_id'];
$data = array('data' => date("Y-m-d H:i:s"), 'confirmed' => 0, 'cus_id' => $_SESSION['user']['id'], 'a_id' => $a_id);

try {
    $db = new dataBase();
    $DBH = $db->connect();
    //condizione per salvare un ordine se nuovo, aggiornarlo altrimenti
    if (isset($_SESSION['user']['oldOrd'])) {
        //aggiorno inidirizzo ordine
        $stmt3 = $DBH->prepare('UPDATE orders SET  addresses_id = :a_id WHERE id = :ord_id');
        $stmt3->execute(array('ord_id' => $_SESSION['user']['oldOrd'], 'a_id' => $a_id));

        foreach ($cart->getProducts() as $row) {
            if (array_key_exists('old', $row)) {
                $stmt = $DBH->prepare('UPDATE orders_has_products SET  
                                        quantity = :qty,
                                        sold_price = :sold_price
                                       WHERE orders_id = :ord_id AND products_id = :prod_id');
                $stmt->execute(array('ord_id' => $_SESSION['user']['oldOrd'], 'prod_id' => $row['id'], 'qty' => $row['qty'], 'sold_price' => $row['price']));
            } else {
                $stmt2 = $DBH->prepare('INSERT INTO orders_has_products (orders_id, products_id, quantity, sold_price) VALUES(:ord_id, :prod_id, :qty, :sold_price)');
                $stmt2->execute(array('ord_id' => $_SESSION['user']['oldOrd'], 'prod_id' => $row['id'], 'qty' => $row['qty'], 'sold_price' => $row['price']));
            }
        }
        $message = gettext('ord.up.usr');
    } else {
        $stmt = $DBH->prepare('INSERT INTO orders(data, confirmed, customers_id, addresses_id)
                                VALUES(:data, :confirmed, :cus_id, :a_id)');
        $stmt->execute($data);

        $ord_id = $DBH->lastInsertId();
        foreach ($cart->getProducts() as $row) {
            $stmt2 = $DBH->prepare('INSERT INTO orders_has_products (orders_id, products_id, quantity, sold_price)
                                                        VALUES(:ord_id, :prod_id, :qty, :sold_price)');

            $stmt2->execute(array('ord_id' => $ord_id, 'prod_id' => $row['id'], 'qty' => $row['qty'], 'sold_price' => $row['price']));
        }
        $message = gettext('ord.conf.usr');
    }
    $cart->emptyCart();

    header('location:../../user/orders/list.php?message=' . $message);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
