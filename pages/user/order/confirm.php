<?php
include '../../../classes/Cart.php';
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

isset($_SESSION['cart']) ? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];


$message = '';
if (!isset($_SESSION['user'])) {
    $message = gettext('ord.must.usr');
    header('location:../../user/login.php?order=yes&message=' . $message);
    exit();
}
$id = $cart->id;
$db = new data_base();
$DBH = $db->connect();
$stmt3 = $DBH->prepare('SELECT MAX(ide) FROM orders  WHERE customers_id = :id');
$stmt3->execute(array('id' => $_SESSION['user']['id']));
$lastide = $stmt3->fetch();
if ($cart->ide) {
    $ide = $cart->ide;
} else {
    $ide = ((int)$lastide['MAX(ide)'] + 1);
}
isset($_SESSION['cart']) ? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];
if (isset($_POST['quotation'])) {
    $quotation = 1;
} else {
    $quotation = 0;
}
if (!isset($cart->id)) {
    $data = array('data' => date("Y-m-d H:i:s"), 'client_id' => $_POST['client_id'],
        'customers_id' => $_SESSION['user']['id'], 'confirmed' => 1, 'quotation' => $quotation, 'ide' => $ide);


    try {
        $stmt = $DBH->prepare('INSERT INTO orders(data, clients_id, customers_id, confirmed, quotation, ide)
                                VALUES(:data, :client_id, :customers_id, :confirmed, :quotation, :ide)');
        $stmt->execute($data);
        $ord_id = $DBH->lastInsertId();
        foreach ($cart->getProducts() as $row) {
            $stmt2 = $DBH->prepare('INSERT INTO orders_has_products (orders_id, products_id, quantity, discount)
                                                        VALUES(:ord_id, :prod_id, :qty, :discount)');
            $stmt2->execute(array('ord_id' => $ord_id, 'prod_id' => $row['id'], 'qty' => $row['qty'], 'discount' => $row['discount']));
        }
        $message = gettext('ord.conf.usr');

        $cart->emptyCart();

        if ($quotation == 0) {
            $message = gettext('ord.conf.usr');
            header('location:../../user/orders/list.php?message=' . $message);
        } else {
            $message = gettext('prev.conf.usr');
            header('location:../../user/quotation/list.php?message=' . $message);
        }
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
} else {

    $data = array('data' => date("Y-m-d H:i:s"), 'client_id' => $_POST['client_id'],
        'customers_id' => $_SESSION['user']['id'], 'confirmed' => 1, 'quotation' => $quotation, 'ide' => $ide, 'id' => $cart->id);
    try {
        $stmt = $DBH->prepare('UPDATE orders SET data = :data, clients_id = :client_id, customers_id = :customers_id,
         confirmed = :confirmed, quotation = :quotation, ide = :ide WHERE id = :id');
        $stmt->execute($data);
        $ord_id = $DBH->lastInsertId();

        $cart->emptyCart();

        if ($quotation == 0) {
            $message = gettext('ord.conf.usr');
            header('location:../../user/orders/list.php?message=' . $message);
        } else {
            $message = gettext('prev.conf.usr');
            header('location:../../user/quotation/list.php?message=' . $message);
        }
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }


}
//PARTE NUOVA


//faccio questo per via di un conflitto con la clase printorder
// I18N support information here
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
putenv('LANG=' . $language);
setlocale(LC_ALL, $language);

// Set the text domain as 'default'
$domain = 'default';
bindtextdomain($domain, $_SERVER["DOCUMENT_ROOT"] . '/catalogoonline/locale');
textdomain($domain);
include '../../../classes/PrintOrder.php';
require_once '../../../vendor/phpmailer/phpmailer/class.phpmailer.php';
$mail = new PHPMailer(true);
$mail->SMTPDebug = true;
$pdf = new PrintOrder($id);
$pdf->deletePDF();
if (file_exists($pdf->getPath())) {
    unlink($pdf->getPath());
}

//crea pdf
$path = $pdf->createPDF('order_details');
$pdf->savePDF($path, 'order_details');
$customer = $pdf->getCustomer();
$order = $pdf->getOrder();
try {
//manda mail con il pdf, non la fattura TO DO : aggiunge nome ditta!
    $mail->AddReplyTo($pdf->queryCompany()['email'], 'prova CatalogoOnLine');
    $mail->SetFrom($pdf->queryCompany()['email'], 'prova CatalogoOnLine');
    $address = $customer['mail'];
    $mail->AddAddress($address, $customer['name']);
    $mail->Subject = gettext('ord') . ' ' . $order['id'] . ' ' . gettext('conf');
    if ($quotation == 1) {
        $mail->MsgHTML(gettext('ord.mail.body.prev') . ' ' . $order['id']);
    } else {
        $mail->MsgHTML(gettext('ord.mail.body') . ' ' . $order['id']);
    }


    $mail->AddAttachment($path); // attachment
    $mail->Send();
    if ($quotation == 0) {
        $mail->addAddress($pdf->queryCompany()['email'], 'prova CatalogoOnLine');
        $mail->Send();
    }
} catch (phpmailerException $e) {
    echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
    echo $e->getMessage(); //Boring error messages from anything else!
}
$_SESSION['client'] = null;


?>
