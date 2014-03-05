<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/customers/show.phtml');

$id = $_GET['id'];
$result = array();

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM clients WHERE id = :id');
    $stmt->execute(array('id' => $id));
    $client = $stmt->fetch();

    $stmt2 = $DBH->prepare('SELECT * FROM comuni WHERE id = :id');
    $stmt2->execute(array('id' => $client['comuni_id']));
    $com = $stmt2->fetch();

    $stmt3 = $DBH->prepare('SELECT * FROM province WHERE id = :id');
    $stmt3->execute(array('id' => $com['id_provincia']));
    $prov = $stmt3->fetch();

    $stmt4 = $DBH->prepare('SELECT * FROM regioni WHERE id = :id');
    $stmt4->execute(array('id' => $prov['id_regione']));
    $reg = $stmt4->fetch();

} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('cust' => $client, 'reg' => $reg, 'prov' => $prov, 'com' => $com));
?>
