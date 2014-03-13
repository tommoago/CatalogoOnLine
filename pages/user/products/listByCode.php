<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('user/products/listByCode.phtml');

$result = array();
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
$limit = 30;
$numPages = 0;
$like = isset($_POST['code']) ? $_POST['code'] : $_GET['code'];


//$stmt2 = $DBH -> prepare('SELECT COUNT(*) FROM products WHERE categories_id = :id AND catalog_id = :id_catl');
//$stmt2 -> execute(array('id' => $_GET['category_id'], 'id_catl' => $catl_id));

try {
    $db = new data_Base();
    $DBH = $db->connect();

    $stmt = $DBH->prepare('SELECT COUNT(*) FROM products WHERE cod LIKE "%'.$like.'%"');
    $stmt->execute();
    $totProd = $stmt->fetch();
    $count = $totProd[0];
    $numPages += intval($count / $limit);
    if ($count % $limit != 0) {
        $numPages++;
    }
    if ($offset != 0)
        $offset *= $limit;

    $stmt = $DBH->prepare('SELECT * FROM products WHERE cod LIKE "%'.$like.'%" LIMIT ' . $offset . ', ' . $limit);
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
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$div = $offset / $limit;
$lowRange = $div - 3;
$maxRange = $div < 3 ? 6 : $div + 3;


$template->display(array('prods' => $result, 'totPages' => $numPages, 'lr' => $lowRange, 'mr' => $maxRange, 'like' => $like));
?>
