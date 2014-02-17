<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/customers/insert.phtml');

$result = array();

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM administrators WHERE role NOT IN ("jack")');
    $stmt->execute();

    $result = $stmt->fetchAll();
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('admins' => $result, 'message' => isset($_GET['message'])? $_GET['message']: ''));
?>
