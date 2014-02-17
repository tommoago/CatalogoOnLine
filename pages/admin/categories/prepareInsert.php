<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/categories/insert.phtml');

$result = array();

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM categories');
    $stmt->execute();

    $result = $stmt->fetchAll();
    //aggiungo cat vuota
    array_unshift($result, array('name' => 'none'));
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('cats' => $result));
?>
