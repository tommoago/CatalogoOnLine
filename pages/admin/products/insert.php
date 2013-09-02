<?php
include '../../../classes/imgUploader.php';
include '../../../classes/dataBase.php';
include '../../../classes/Session.php';
$session = new Session();

$img = new imgUploader();
$img->startUpload($_FILES['uploaded']['name'], $_FILES['uploaded']['tmp_name']);
$pathName = $img->getPathName();

$name = $_POST['name'];
$description = $_POST['descr'];
$new = 0;
if (isset($_POST['new'])) {
    $new = 1;
}
$offer = 0;
if (isset($_POST['offer'])) {
    $offer = 1;
}
$evidence = 0;
if (isset($_POST['evidence'])) {
    $evidence = 1;
}
$wholesale_price = $_POST['w_price'];
$retail_price = $_POST['r_price'];
$super_price = $_POST['s_price'];
$purchase_price = $_POST['p_price'];
$cod = $_POST['cod'];
$barcode = $_POST['barcode'];
$single_qty = $_POST['s_qty'];
$pack_qty = $_POST['p_qty'];
$cardboard_qty = $_POST['c_qty'];
$categories_id = $_POST['cat_id'];

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $data = array('name' => $name,
        'descr' => $description,
        'new' => $new,
        'offer' => $offer,
        'evidence' => $evidence,
        'w_price' => $wholesale_price,
        'r_price' => $retail_price,
        's_price' => $super_price,
        'p_price' => $purchase_price,
        'cod' => $cod,
        'barcode' => $barcode,
        's_qty' => $single_qty,
        'p_qty' => $pack_qty,
        'c_qty' => $cardboard_qty,
        'cat_id' => $categories_id);

    $STH = $DBH->prepare('INSERT INTO products (name, description, new, offer, evidence, 
                                                wholesale_price, retail_price, super_price,
                                                purchase_price, cod, barcode, single_qty,
                                                pack_qty, cardboard_qty, categories_id) 
                                        value (:name, :descr, :new, :offer, :evidence, :w_price,
                                               :r_price, :s_price, :p_price, :cod, :barcode,
                                               :s_qty, :p_qty, :c_qty, :cat_id)');
    $STH->execute($data);
    $idProd = $DBH->lastInsertId();
    
    $data2 =array('path' => $pathName,
                  'prod_id' => $idProd);
    $STH2 = $DBH->prepare('INSERT INTO product_images (path, products_id) 
                                                value (:path, :prod_id)');
    $STH2->execute($data2);
//    header('location:show.php?id='.$idProd);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
