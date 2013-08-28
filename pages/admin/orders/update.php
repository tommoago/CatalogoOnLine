<?php

$username = 'root';
$password = 'root';

$id = $_POST['id'];
$confirmed = 0;
if (isset($_POST['confirmed'])) {
    $confirmed = 1;
}

try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);

     $data = array('confirmed' => $confirmed, 'id' => $id);

    $STH = $DBH->prepare('UPDATE customers SET  
                            confirmed = :confirmed
                          WHERE id = :id');
    $STH->execute($data);
    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>