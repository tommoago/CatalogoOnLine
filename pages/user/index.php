<?php
include '../../conf/config.php';
include '../../classes/Cart.php';
include '../../conf/twig.php';
include '../../classes/Session.php';
$session = new Session();
isset($_SESSION['cart']) ? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];

if (isset($_SESSION['client'])) {
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
