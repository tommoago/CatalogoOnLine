<?php
include '../../../classes/dataBase.php';
include '../../../classes/imgUploader.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_POST['id'];

try {
    $db = new dataBase();
    $DBH = $db->connect();

    $pathName = '';
    if ($_FILES['uploaded']['name'] != '') {
        $img = new imgUploader();
        $img->startUpload($_FILES['uploaded']['name'], $_FILES['uploaded']['tmp_name']);
        $pathName = $img->getPathName();
    }


    if ($pathName != '') {
        $data2 = array('path' => $pathName, 'id' => $id);
        $STH2 = $DBH->prepare('UPDATE  company_images SET
                                       path = :path 
                               WHERE company_info_id = :id');

        $STH2->execute($data2);
    }

    header('location:viewImages.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
