<?php
include '../../conf/config.php';
include '../../conf/twig.php';
include '../../classes/Session.php';
$session = new Session();

if(isset($_SESSION['client'])){
    header('location: actions/index.php');

};

$template = $twig->loadTemplate('user/structure/index.phtml');

$db = new data_Base();
$DBH = $db->connect();
$stmt = $DBH->prepare('SELECT * FROM clients');
$stmt->execute();
$result = $stmt->fetchAll();

$template->display(array('usr' => $_SESSION['user'], 'index' => 'true', 'clients' => $result));
?>
