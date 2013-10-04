<?php

include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$street = $_POST['street'];
$city = $_POST['city'];
$prov = $_POST['prov'];
$zip = $_POST['zip'];
$country = $_POST['country'];
$c_id = $_POST['cus_id'];


try {
    $db = new dataBase();
    $DBH = $db->connect();
    $data = array('street' => $street,
        'city' => $city,
        'prov' => $prov,
        'zip' => $zip,
        'country' => $country);
    $STH = $DBH->prepare('INSERT INTO addresses (street, 
                                                 city,
                                                 province,
                                                 zip,
                                                 country) 
                                           value (:street, 
                                                  :city,
                                                  :prov,
                                                  :zip,
                                                  :country)');
    $STH->execute($data);
    
    $a_id = $DBH->lastInsertId();
    $data2 = array('c_id' => $c_id, 'a_id' => $a_id);
    $STH2 = $DBH->prepare('INSERT INTO customers_has_addresses (customers_id, addresses_id) 
                                                         value (:c_id, :a_id)');
    $STH2->execute($data2);

    header('location:show.php?id=' . $c_id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
