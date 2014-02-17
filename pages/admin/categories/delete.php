<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_GET['id'];
$message = '';
$data = array('id' => $id);
try {
    $db = new data_Base();
    $DBH = $db->connect();

    //cerco categorie associate
    $stmt = $DBH->prepare('SELECT * FROM categories WHERE categories_id = :id');
    $stmt->execute($data);
    $categories = $stmt->fetchAll();

    if (empty($categories)) {
        //cerco prodotti associati
        $STH = $DBH->prepare('SELECT * FROM products WHERE categories_id = :id');
        $STH->execute($data);
        $products = $STH->fetchAll();
        if (empty($products)) {
            //se non ho vincoli, elimino.
            $STH = $DBH->prepare('DELETE FROM categories WHERE id = :id');
            $STH->execute($data);
            $message = gettext('del.succ');
        } else {
            $message = gettext('del.dep.prod');
        }
    } else {
        $message = gettext('cat.del.dep.cat');
    }

    header('location:list.php?message=' . $message);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
