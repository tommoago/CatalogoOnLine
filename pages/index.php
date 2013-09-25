<?php
include '../classes/Cart.php';
include '../conf/config.php';
include '../conf/twig.php';

isset($_SESSION['cart'])? : $_SESSION['cart'] = new Cart();

$template = $twig->loadTemplate('index.phtml');

$result = array();

try {

    $db = new dataBase();
    $DBH = $db->connect();

    $stmt = $DBH->prepare('SELECT * FROM products  WHERE evidence = 1');
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as &$row) {
        $stmt4 = $DBH->prepare('SELECT * FROM product_images WHERE products_id = :id');
        $stmt4->execute(array('id' => $row['id']));
        $imm = $stmt4->fetch();
        $row['image'] = $imm['path'];
        
        $row['description'] = substr($row['description'], 0, 150) .'...';

        //mette il prezzo giusto vediamo se farlo comparire nelle slide
        $row['price'] = $row['retail_price'];
        if (isset($_SESSION['user']['price_range']))
            switch ($_SESSION['user']['price_range']) {
                case 1:
                    $row['price'] = $row['wholesale_price'];
                    break;
                case 2:
                    $row['price'] = $row['retail_price'];
                    break;
                case 3:
                    $row['price'] = $row['super_price'];
                    break;
            }
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('index' => 'yes', 'prods' => $result));
?>
