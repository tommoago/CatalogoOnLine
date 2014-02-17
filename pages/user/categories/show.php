<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/categories/show.phtml');

$id = $_GET['id'];
$result = array();

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
    $stmt->execute(array('id' => $id));

    $category = $stmt->fetch();
    
    $stmt2 = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
    $stmt2->execute(array('id' => $category['categories_id']));
    $cat = $stmt2->fetch();
    $category['category'] = $cat['name'];
    if($cat['name'] == ''){
        $category['category'] = 'none';
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('cat' => $category));
?>
