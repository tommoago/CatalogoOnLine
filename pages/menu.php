<?php

include '../conf/config.php';
include '../conf/twig.php';
$template = $twig->loadTemplate('menu.phtml');

$result = array();
try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM categories WHERE categories_id IS NULL');
    $stmt->execute();

    $result = $stmt->fetchAll();

    foreach ($result as &$row) {
        $stmt = $DBH->prepare('SELECT * FROM categories WHERE categories_id = :id');
        $stmt->execute(array('id' => $row['id']));
        $row['category'] = '';
        $row['category'] = $stmt->fetchAll();
        foreach ($row['category'] as &$row2) {
            $stmt2 = $DBH->prepare('SELECT * FROM categories WHERE categories_id = :id');
            $stmt2->execute(array('id' => $row2['id']));
            $row2['category'] = '';
            $row2['category'] = $stmt2->fetchAll();
        }
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
echo json_encode($result);
?>
