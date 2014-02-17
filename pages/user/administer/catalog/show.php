<?php
include '../../../../conf/config.php';
include '../../../../conf/twig.php';
include '../../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('user/administer/catalog/show.phtml');

$id = $_GET['id'];
$result = array();

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM catalog WHERE id = :id');
    $stmt->execute(array('id' => $id));
    $catalog = $stmt->fetch();
   
    
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('cat' => $catalog));
?>
