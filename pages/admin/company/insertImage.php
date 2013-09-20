<?php

include '../../../classes/dataBase.php';
include '../../../classes/imgUploader.php';
include '../../../classes/Session.php';
$session = new Session();
if (!$session->check_role('jack')) {
    header('location:../index.php?message= Unauthorized access.');
}

$id = $_POST['id'];

try {
    $db = new dataBase();
    $DBH = $db->connect();

    $pathName = '';
    if ($_FILES['uploaded']['name'] != '') {
        $img = new imgUploader();
        $message = $img->startUpload($_FILES['uploaded']['name'], $_FILES['uploaded']['tmp_name']);
        if($message != ''){
            header('location:addImage.php?id=' . $id . '&message=' .$message);
            exit;
        }
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
