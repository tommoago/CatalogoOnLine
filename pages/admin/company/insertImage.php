<?php
include '../../../classes/dataBase.php';
include '../../../classes/imgUploader.php';
include '../../../classes/Session.php';
$session = new Session();
if(!$session->check_role('jack')){
   header('location:../index.php?message= Unauthorized access.'); 
}

$id = $_POST['id'];

try {
    $db = new dataBase();
    $DBH = $db->connect();

    $pathName = '';
    print_r($_FILES['uploaded']['name']);
    if ($_FILES['uploaded']['name'] != '') {
        $img = new imgUploader();
        $img->startUpload($_FILES['uploaded']['name'], $_FILES['uploaded']['tmp_name']);
        $pathName = $img->getPathName();
        
        $data2 = array('path' => $pathName, 'id' => $id);
        $STH2 = $DBH->prepare('INSERT INTO company_images (path, company_info_id)
                                             VALUE (:path, :id)');

        $STH2->execute($data2);
    }

    header('location:viewImages.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>