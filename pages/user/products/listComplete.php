<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('user/products/listComplete.phtml');

$result = array();


//$stmt2 = $DBH -> prepare('SELECT COUNT(*) FROM products WHERE categories_id = :id AND catalog_id = :id_catl');
//$stmt2 -> execute(array('id' => $_GET['category_id'], 'id_catl' => $catl_id));

try {
    $db = new data_Base();
    $DBH = $db->connect();


    $stmt = $DBH->prepare('SELECT * FROM products ');
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as &$row) {
        if (strlen($row['description']) > 150)
            $row['description'] = substr($row['description'], 0, 80) . '...';

        $stmt = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt->execute(array('id' => $row['categories_id']));
        $cat = $stmt->fetch();
        $row['category'] = $cat['name'];

        $stmt2 = $DBH->prepare('SELECT * FROM catalog WHERE id = :id');
        $stmt2->execute(array('id' => $row['catalog_id']));
        $sup = $stmt2->fetch();
        $row['catalog'] = $sup['name'];

        $stmt2 = $DBH->prepare('SELECT * FROM product_images WHERE products_id = :id');
        $stmt2->execute(array('id' => $row['id']));
        $sup = $stmt2->fetch();
        $row['image'] = $sup['path'];
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}


$template->display(array('prods' => $result));
?>
