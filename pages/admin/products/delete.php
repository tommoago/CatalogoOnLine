<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_GET['id'];

try {
    $db = new data_Base();
    $DBH = $db->connect();
    
    $stmt3 = $DBH->prepare('SELECT * FROM product_images WHERE products_id = :id');
    $stmt3->execute(array('id' => $id));
    $imm = $stmt3->fetch();
    print_r($imm);
	if($imm['path'] != null )
    unlink('../../../'.$imm['path']);
	
    $STH = $DBH->prepare('DELETE FROM product_images WHERE products_id = :id');
    $data = array('id' => $id);
    $STH->execute($data);
    
    $STH = $DBH->prepare('DELETE FROM orders_has_products WHERE products_id = :id');
    $STH->execute($data);
    
    $STH = $DBH->prepare('DELETE FROM products WHERE id = :id');
    $STH->execute($data);
    
    header('location:list.php');
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
