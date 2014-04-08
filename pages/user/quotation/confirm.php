<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_GET['id'];

try {
    $db = new data_Base();
    $DBH = $db->connect();

    $STH = $DBH->prepare('UPDATE orders SET
                            confirmed = 1,
                            quotation = 0
                          WHERE id = :id');
    $STH->execute(array(('id') => $id));


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
        if ($pdf->getOrder()['quotation'] == 1) {
            $mail->MsgHTML(gettext('ord.mail.body.prev') . ' ' . $order['id']);
        } else {
            $mail->MsgHTML(gettext('ord.mail.body') . ' ' . $order['id']);
        }


        $mail->AddAttachment($path); // attachment
        $mail->Send();
        if ($pdf->getOrder()['quotation'] == 0) {
            $mail->addAddress($pdf->queryCompany()['email'], 'prova CatalogoOnLine');
            $mail->Send();
        }
    } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
    }


    header('location:show.php?id=' . $id);


} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
