<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

if (isset($_GET['client_id'])) {
    $_SESSION['client'] = $_GET['client_id'];
};

$template = $twig->loadTemplate('user/actions/index.phtml');
$ide = '';
$db = new data_base();
$DBH = $db->connect();
$stmt3 = $DBH->prepare('SELECT * FROM orders  WHERE customers_id = :id AND  confirmed = 0 AND clients_id = :clients_id');
$stmt3->execute(array('id' => $_SESSION['user']['id'], 'clients_id' => $_SESSION['client_id']));
$oldOrd = $stmt3->fetch();
if (isset($oldOrd)) {
    $ide = $oldOrd['ide'];
}

$template->display(array('ide' => $ide));
?>
