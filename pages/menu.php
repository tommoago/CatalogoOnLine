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
        $stmt->execute();
        $row['category'] = '';
        $row['category'] = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
echo json_encode($result);
?>
