<?php
include '../../../classes/dataBase.php';
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
include '../../../classes/Session.php';
$session = new Session();
if(!$session->check_role('jack')){
   header('location:../index.php?message= Unauthorized access.'); 
}

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/*, array('cache' => '../../../templates/cache')*/);
$template = $twig->loadTemplate('admin/administrators/list.phtml');

$result = array();
isset($_GET['offset'])? $offset = $_GET['offset']: $offset =0 ;
$limit = 10;
$numPages = 0;

$message = '';
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
try {
    $db = new dataBase();
    $DBH = $db->connect();
    
    $stmt = $DBH->prepare('SELECT COUNT(*) FROM administrators');
    $stmt->execute();
    $totAdmin = $stmt->fetch();
    $count = $totAdmin[0];
    $numPages += intval($count/$limit);
    if($count%$limit != 0){
        $numPages++;
    }
    if($offset != 0 ) $offset *= $limit;
    
    $stmt2 = $DBH->prepare('SELECT * FROM administrators LIMIT ' . $offset . ', ' . $limit);
    $stmt2->execute();
    $result = $stmt2->fetchAll();

} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$lowRange = $offset/$limit-3;
$maxRange = $offset/$limit;
$maxRange < 3? $maxRange = 6 : $maxRange += 3;

$template->display(array('admins' => $result, 'message' => $message, 'totPages' => $numPages, 'lr' => $lowRange, 'mr' => $maxRange));
?>
