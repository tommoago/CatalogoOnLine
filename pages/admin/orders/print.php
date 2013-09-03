<?php

include '../../../classes/fpdf.php';
include '../../../classes/dataBase.php';
include '../../../classes/Session.php';
$session = new Session();
define('FPDF_FONTPATH','../../../files/font/');

$id = $_GET['id'];
$fileType = $_GET['filetype'];
$data = array('id' => $id);

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM orders WHERE id = :id');
    $stmt->execute($data);
    $order = $stmt->fetch();

    $stmt2 = $DBH->prepare('SELECT * FROM customers WHERE id = :id');
    $stmt2->execute(array('id' => $order['customers_id']));
    $cus = $stmt2->fetch();
    $order['customer'] = $cus['name'];

    $stmt3 = $DBH->prepare('SELECT * FROM products p, orders_has_products op 
                            WHERE op.orders_id = :id AND p.id = op.products_id');
    $stmt3->execute($data);
    $products = $stmt3->fetchAll();
    
    $stmt4 = $DBH->prepare('SELECT * FROM company_info');
    $stmt4->execute();
    $company = $stmt4->fetch();
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

//Crea un nuevo pdf
$pdf = new FPDF();

//Disable automatic page break
$pdf->SetAutoPageBreak(true);

//prima pagina
$pdf->AddPage();
$pdf->Image('../../../images/appleRedLogo.jpg', 5, 10, '30%');

//altezza riga
$row_height = 6;
//N max righe per pagina
$max = 40;
$rows = count($products);

//margini iniziali posizione pagina
$y_axis_initial = 0;
$x_axis = 10;
$y_axis = 70;
$y_axis1 = 64;
$y_axis2 = ($rows * 6) + 70;
$x_axis2 = 90;
$y_axis3 = 46;

//imprime los titulos de columna para la pagina (quitar comentarios para activar)
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 11);

//set company info
$pdf->SetY(15);
$pdf->SetX(150);
$pdf->Cell('100%', 6, $company['name'] , 0);
$pdf->SetY(15+$row_height);
$pdf->SetX(150);
$pdf->Cell('100%', 6, 'Tel.: '.$company['telephone'] , 0);
$pdf->SetY(15+($row_height*2));
$pdf->SetX(150);
$pdf->Cell('100%', 6, 'P.IVA: '.$company['piva'] , 0);
$pdf->SetY(15+($row_height*3));
$pdf->SetX(150);
$pdf->Cell('100%', 6, $company['address'] , 0);

//set customer info
$pdf->SetY($y_axis3);
$pdf->SetX($x_axis);
$pdf->Cell('15%', 6, 'Cliente: lol' , 0);
$pdf->Ln();

$pdf->SetY($y_axis1);
$pdf->SetX($x_axis);
$pdf->Cell('15%', 6, 'Quantita', 1, 0, 'C');
$pdf->Cell('65%', 6, 'Articolo', 1, 0, 'C');
$pdf->Cell('20%', 6, 'Prezzo', 1, 0, 'C');

$pdf->SetFont('Arial', 'I', 10);

//inizializzazone contatore e prezzo totale
$i = 0;
$tot = 0;
foreach ($products as $row) {
//Si la fila actual es la ultima, creo una nueva página e imprimo el titulo (quitar comentarios para activar)
    if ($i == $max) {
        $pdf->AddPage();

//Go to next row
        $y_axis += $row_height;

//Set $i variable to 0 (first row)
        $i = 0;
    }
    
    $pdf->SetY($y_axis);
    $pdf->SetX($x_axis);
    $pdf->Cell('15%', 6, $row['quantity'], 1, 0, 'C');
    $pdf->Cell('65%', 6, $row['name'], 1, 0, 'C');
    $pdf->Cell('20%', 6, $row['sold_price'], 1, 0, 'C');

    $pdf->SetTextColor(0, 0, 0);
//Go to next row
    $y_axis += $row_height;
    $i++;
    $tot += $row['sold_price'] * $row['quantity'];
}

$pdf->SetY($y_axis2);
$pdf->SetX($x_axis2);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell('25%', 6, 'Totale Ordine: ', 0, 0, 'C');
$pdf->Cell('25%', 6, $tot, 1, 0, 'C');

//Convert the date 
$oDate = new DateTime($order['data']);
$sDate = $oDate->format("d-m-y");
//Create file
$fileName = $fileType . '-order' . $order['id'] . '-date' . $sDate . '.pdf';
$filePath = '../../../files/' . $fileType . '/' . $fileName ;
chmod('../../../files/' . $fileType  , 0777);
$pdf->Output( $filePath, 'I');

$save = array('path' => $filePath, 'id' => $id);
try {
    $stmt5 = $DBH->prepare('INSERT INTO invoices (path,
                                                  orders_id) 
                                           value (:path,
                                                  :id)');
    $stmt5->execute($save);
    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
