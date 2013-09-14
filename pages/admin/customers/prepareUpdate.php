<?php

include '../../../classes/dataBase.php';
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
include '../../../classes/Session.php';
$session = new Session();

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('admin/customers/update.phtml');

$id = $_GET['id'];

try {
    $db = new dataBase();
    $DBH = $db->connect();

    $stmt = $DBH->prepare('SELECT * FROM customers WHERE id = :id');
    $stmt->execute(array('id' => $id));
    //tira fuori solo un risultato
    $customer = $stmt->fetch();

    $stmt = $DBH->prepare('SELECT * FROM administrators WHERE role NOT IN ("jack")');
    $stmt->execute();
    $result = $stmt->fetchAll();

    $customer['c_active'] = '';
    if ($customer['active'] == 1) {
        $customer['c_active'] = 'checked';
    }

    //marca l'operatore appartenente 
    foreach ($result as &$row) {
        $row['selected'] = '';
        if ($row['id'] == $customer['administrators_id']) {
            $row['selected'] = 'selected';
        }
    }

    switch ($customer['type']) {
        case 'user':
            $customer['selected_u'] = 'selected';
            break;
        case 'merchant':
            $customer['selected_m'] = 'selected';
            break;
        case 'stockist':
            $customer['selected_s'] = 'selected';
            break;
    }
    
    switch ($customer['price_range']) {
        case '1':
            $customer['selected_pw'] = 'selected';
            break;
        case '2':
            $customer['selected_pr'] = 'selected';
            break;
        case '3':
            $customer['selected_ps'] = 'selected';
            break;
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('cus' => $customer, 'admins' => $result));
?>
