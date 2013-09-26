<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_GET['id'];
$data = array('id' => $id);
try {
    $db = new dataBase();
    $DBH = $db->connect();

    //cerco ordini associati
    $stmt = $DBH->prepare('SELECT * FROM orders WHERE customers_id = :id');
    $stmt->execute($data);
    $orders = $stmt->fetchAll();

// vecchia implementazione, con vincoli di eliminazione, tenere.
//    if (empty($orders)) {
//        //se non ho vincoli, elimino.
//        $STH = $DBH->prepare('DELETE FROM customers WHERE id = :id');
//        $STH->execute($data);
//        $message = 'Delete successful';
//    } else {
//        $STH = $DBH->prepare('UPDATE customers SET active = 0 WHERE id = :id');
//        $STH->execute($data);
//        $message = 'Cannot delete because of depency with 1 or more orders, the account has been disactivated';
//    }
    if (!empty($orders)) {
        //se il customer ha fatto degli ordini devo inserire il suo nome nel campo prima di cancellarlo.
        $stmt = $DBH->prepare('SELECT * FROM customers WHERE id = :id');
        $stmt->execute($data);
        $customer = $stmt->fetch();
        
        foreach ($orders as $ord) {
            $STH = $DBH->prepare('UPDATE orders SET  
                                    customers_id = :name
                                  WHERE id = :id');
            $STH->execute(array('name' => $customer['name'], 'id' => $ord['id']));
        }
    }
    $STH = $DBH->prepare('DELETE FROM customers WHERE id = :id');
    $STH->execute($data);
    $message = gettext('del.succ');

    header('location:list.php?message=' . $message);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
