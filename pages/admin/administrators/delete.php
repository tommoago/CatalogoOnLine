<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();
if(!$session->check_role('jack')){
   header('location:../index.php?message='. gettext('unauth')); 
}

$id = $_GET['id'];
$message = '';
$data = array('id' => $id);
try {
    $db = new data_Base();
    $DBH = $db->connect();

    //cerco customers associati
    $stmt = $DBH->prepare('SELECT * FROM customers WHERE administrators_id = :id');
    $stmt->execute($data);
    $customers = $stmt->fetchAll();

    if (empty($customers)) {
        //seleziono per salvarlo nel dettaglio dell'ordine
        $stmt2 = $DBH->prepare('SELECT * FROM administrators WHERE id = :id');
        $stmt2->execute($data);
        $admin = $stmt2->fetch();
        
        $stmt3 = $DBH->prepare('UPDATE orders SET operator = :op WHERE operator = :id');
        $stmt3->execute(array('op' => $admin['name'], 'id' =>$admin['id']));

        //se non ho vincoli, elimino.
        $STH = $DBH->prepare('DELETE FROM administrators WHERE id = :id');
        $STH->execute($data);
        $message = gettext('del.succ');
    } else {
        $message = gettext('adm.del.dep');
    }

    header('location:list.php?message=' . $message);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
