<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/users/update.phtml');

$id = $_GET['id'];
$result = array();

try {
    $db = new data_Base();
    $DBH = $db->connect();

    $stmt = $DBH->prepare('SELECT * FROM customers WHERE id = :id');
    $stmt->execute(array('id' => $_GET['id']));
    $cust = $stmt->fetch();



} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('cust' => $cust, 'message' => isset($_GET['message']) ? $_GET['message'] : ''));
