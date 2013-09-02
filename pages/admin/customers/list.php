<?php
include '../../../classes/dataBase.php';
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
include '../../../classes/Session.php';
$session = new Session();

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('admin/customers/list.phtml');

$result = array();
$message = '';
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM customers');
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as &$row) {
        $stmt2 = $DBH->prepare('SELECT * FROM administrators WHERE id = :id');
        $stmt2->execute(array('id' => $row['administrators_id']));
        $adm = $stmt2->fetch();
        $row['operator'] = $adm['user'];
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('customers' => $result, 'message' => $message));
?>
