<?php

require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates/admin/categories');
$twig = new Twig_Environment($loader/*, array('cache' => '../../../templates/cache')*/);
$template = $twig->loadTemplate('update.phtml');

$username = 'root';
$password = 'root';
$id = $_GET['id'];
$result = array();

try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
    $stmt = $DBH->prepare('SELECT * FROM categories');
    $stmt->execute();
    $result = $stmt->fetchAll();

    $stmt = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
    $stmt->execute(array('id' => $id));
    //tira fuori solo un risultato
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
    print_r($result);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('cat' => $category, 'cats' => $result));
?>
