<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

for ($i = 0; 1000 > $i; $i++) {
    try {
        $db = new data_Base();
        $DBH = $db->connect();
        $data = array('name' => time(),
            'descr' => 'description' . time(),
            'new' => 0,
            'offer' => 0,
            'evidence' => 0,
            'w_price' => 45 * (1 + (50 / 100)),
            'r_price' => 45 * (1 + (55 / 100)),
            's_price' => 45 * (1 + (45 / 100)),
            'p_price' => 45,
            'cod' => '0000000000',
            'barcode' => '0000000000',
            's_qty' => 1,
            'p_qty' => 1,
            'c_qty' => 1,
            'vat' => 15,
            'cat_id' => rand(50, 70),
            'catl_id' => rand(29, 31));

        $STH = $DBH->prepare('INSERT INTO products (name, description, new, offer, evidence,
                                                wholesale_price, retail_price, super_price,
                                                purchase_price, cod, barcode, single_qty,
                                                pack_qty, cardboard_qty, vat, categories_id, catalog_id)
                                        value (:name, :descr, :new, :offer, :evidence, :w_price,
                                               :r_price, :s_price, :p_price, :cod, :barcode,
                                               :s_qty, :p_qty, :c_qty, :vat, :cat_id, :catl_id)');
        $STH->execute($data);
        $idProd = $DBH->lastInsertId();


        echo 'ok';

    } catch
    (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}
?>
