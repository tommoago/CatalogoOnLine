<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();
if(!$session->check_role('jack')){
   header('location:../index.php?message='. gettext('unauth')); 
}

$id = $_POST['id'];
$name = $_POST['name'];
$description= $_POST['description'];
$piva = $_POST['piva'];
$telephone = $_POST['telephone'];
$fax = $_POST['fax'];
$address = $_POST['address'];
$city = $_POST['city'];
$province = $_POST['province'];
$country = $_POST['country'];
$zip = $_POST['zip'];
$email = $_POST['email'];
$website = $_POST['website'];

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $data = array('name' => $name, 
                  'description' => $description, 
                  'piva' => $piva, 
                  'telephone' =>$telephone, 
                  'fax' =>$fax,
                  'address' =>$address,
                  'city' =>$city,
                  'province' =>$province,
                  'country' =>$country,
                  'zip' =>$zip,
                  'email' =>$email,
                  'website' =>$website,
                  'id' => $id);

    $STH = $DBH->prepare('UPDATE company_info SET  
                            name = :name, 
                            description = :description, 
                            piva = :piva, 
                            telephone = :telephone, 
                            fax = :fax,
                            address = :address,
                            city = :city,
                            province = :province,
                            country = :country,
                            zip = :zip,
                            email = :email,
                            website = :website
                          WHERE id = :id');
    $STH->execute($data);
    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>