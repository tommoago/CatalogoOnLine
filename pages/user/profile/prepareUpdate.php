<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('user/profile/update.phtml');

$id = $_GET['id'];

try {
    $db = new data_Base();
    $DBH = $db->connect();

    $stmt = $DBH->prepare('SELECT * FROM customers WHERE id = :id');
    $stmt->execute(array('id' => $id));
    //tira fuori solo un risultato
    $user = $stmt->fetch();
    
    switch ($user['type']) {
    case 'user':
        $user['selected_u']= 'selected';
        break;
    case 'seller':
        $user['selected_s']= 'selected';
        break;
    case 'other':
        $user['selected_o']= 'selected';
        break;
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('usr' => $user, 'message' => isset($_GET['message'])? $_GET['message']: ''));
?>
