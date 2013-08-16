<?php


$id = 1;
$username = "root"; 
$password = "root";
try {
  $conn = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
  $stmt = $conn->prepare('SELECT * FROM products WHERE id = :id');
  $stmt->execute(array('id' => $id));
 
  $result = $stmt->fetchAll();
 
  if ( count($result) ) { 
    foreach($result as $row) {
      print_r($row);
    }   
  } else {
    echo "No rows returned.";
  }
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
