<?php
include '../../../classes/Cart.php';
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

isset($_SESSION['cart']) ? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];

try {
    $db = new data_Base();
    $DBH = $db->connect();

    $stmt = $DBH->prepare('SELECT * FROM products  WHERE id = :id');
    $stmt->execute(array('id' => $_POST['id']));
    $product = $stmt->fetch();
    $product['qty'] = 1;
    if (isset($_POST['qty_add']) && $_POST['qty_add'] != '' && $_POST['qty_add'] != 0)
        $product['qty'] = $_POST['qty_add'];

    //mette il prezzo giusto
    $product['price'] = $product['retail_price'];
    $product['discount_price'] = $product['retail_price'] * (100 - $_POST['discount']) / 100;
    /*  if (isset($_SESSION['user']['price_range']))
          switch ($_SESSION['user']['price_range']) {
              case 1:
                  $product['price'] = $product['wholesale_price'];
                  break;
              case 3:
                  $product['price'] = $product['super_price'];
                  break;
          }*/

    $stmt2 = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
    $stmt2->execute(array('id' => $product['categories_id']));
    $cat = $stmt2->fetch();
    $product['category'] = $cat['name'];

} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
$cart->addProduct(array('id' => $product['id'], 'description' => $product['description'], 'price' => $product['price'], 'discount_price' => $product['discount_price'], 'qty' => $product['qty'], 'discount' => $_POST['discount']));

if (isset($_SESSION['client'])) {
    try {
        $data = array('data' => date("Y-m-d H:i:s"), 'client_id' => $_SESSION['client'],
            'customers_id' => $_SESSION['user']['id'], 'confirmed' => 0, 'quotation' => 0, 'ide' => null);
        if (!isset($cart->id)) {
            $stmt = $DBH->prepare('INSERT INTO orders(data, clients_id, customers_id, confirmed, quotation, ide)
                                VALUES(:data, :client_id, :customers_id, :confirmed, :quotation, :ide)');
            $stmt->execute($data);
            $ord_id = $DBH->lastInsertId();
            $cart->id = $ord_id;
        }

        foreach ($cart->getProducts() as $row) {
            $stmt2 = $DBH->prepare('INSERT INTO orders_has_products (orders_id, products_id, quantity, discount)
                                                        VALUES(:ord_id, :prod_id, :qty, :discount)
                                                        ON DUPLICATE KEY UPDATE quantity = quantity + :qty, discount = :discount ');
            $stmt2->execute(array('ord_id' => $cart->id, 'prod_id' => $row['id'], 'qty' => $row['qty'], 'discount' => $row['discount']));
        }
        $message = gettext('ord.conf.usr');

        //$cart->emptyCart();

        //header('location:../../user/orders/list.php?message=' . $message);
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}

//header('location:list.php');
?>
