<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/categories/update.phtml');

$id = $_GET['id'];
$result = array();

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM categories');
    $stmt->execute();
    $result = $stmt->fetchAll();

    $stmt = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
    $stmt->execute(array('id' => $id));
    $category = $stmt->fetch();
    
    //marca la categoria appartenente ed esclude se stessa
    $i = 0;
    foreach($result as &$row) {
      $row['selected'] = '';
      if ($row['id'] == $category['categories_id']){
          $row['selected'] = 'selected';
      }
      if($row['id'] == $category['id']){
          unset($result[$i]);
      }
      $i++;
    } 
    //aggiungo cat vuota
    if($category['categories_id']== '')
        array_unshift($result, array('name' => 'none'));
    
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('cat' => $category, 'cats' => $result));
?>
