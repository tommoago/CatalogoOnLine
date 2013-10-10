<?php
include '../../../conf/config.php';
include '../../../classes/imgUploader.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_POST['id'];
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
$vat = $_POST['vat'];
$categories_id = $_POST['cat_id'];
$suppliers_id = $_POST['sup_id'];

try {
    $db = new dataBase();
    $DBH = $db->connect();

    $pathName = '';
    if ($_FILES['uploaded']['name'] != '') {
        //upload nuova immagine
        $img = new imgUploader();
        $message = $img->startUpload($_FILES['uploaded']['name'], $_FILES['uploaded']['tmp_name']);
        if ($message != '') {
            header('location:prepareInsert.php?message=' . $message);
            exit;
        }
        $pathName = $img->getPathName();
        
        //cerco precedenti occurences
        $stmt3 = $DBH->prepare('SELECT * FROM product_images WHERE products_id = :id');
        $stmt3->execute(array('id' => $id));
        $imm = $stmt3->fetchAll();

        $data2 = array('path' => $pathName, 'id' => $id);
        if (!empty($imm)) {
            unlink('../../' . $imm['path']);
            
            $STH2 = $DBH->prepare('UPDATE  product_images SET
                                           path = :path 
                                   WHERE products_id = :id');
            $STH2->execute($data2);
        }else{
            //se non esiste la voce, la inserisco
            $STH2 = $DBH->prepare('INSERT INTO product_images (path, products_id) 
                                                    value (:path, :id)');
            $STH2->execute($data2);
        }
        
    }

    $data = array('name' => $name,
        'descr' => $description,
        'new' => $new,
        'offer' => $offer,
        'evidence' => $evidence,
        'w_price' => round($purchase_price * (1 + ($wholesale_price / 100)),2),
        'r_price' => round($purchase_price * (1 + ($retail_price / 100)),2),
        's_price' => round($purchase_price * (1 + ($super_price / 100)),2),
        'p_price' => $purchase_price,
        'cod' => $cod,
        'barcode' => $barcode,
        's_qty' => $single_qty,
        'p_qty' => $pack_qty,
        'c_qty' => $cardboard_qty,
        'vat' => $vat,
        'cat_id' => $categories_id,
        'sup_id' => $suppliers_id,
        'id' => $id);

    $STH = $DBH->prepare('UPDATE products SET  
                            name = :name, 
                            description = :descr, 
                            new = :new, 
                            offer = :offer, 
                            evidence = :evidence, 
                            wholesale_price = :w_price, 
                            retail_price = :r_price, 
                            super_price = :s_price,
                            purchase_price = :p_price, 
                            cod = :cod, 
                            barcode = :barcode, 
                            single_qty = :s_qty,
                            pack_qty = :p_qty, 
                            cardboard_qty = :c_qty, 
                            vat = :vat,
                            categories_id =  :cat_id,
                            suppliers_id =  :sup_id
                          WHERE id = :id');
    $STH->execute($data);

    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
