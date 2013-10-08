<?php

include 'fpdf.php';
include 'dataBase.php';
include $_SERVER['DOCUMENT_ROOT'].'/melarossa/vendor/mpdf/mpdf.php';

define('FPDF_FONTPATH', '../../../files/font/');

class PrintOrder {

var $html ='<body>
        <div id="wrapper">

            <p style="text-align:center; font-weight:bold; padding-top:5mm;">INVOICE</p>
            <br />
            <table class="heading" style="width:100%;">
                <tr>
                    <td style="width:80mm;">
                        <h1 class="heading">ABC Corp</h1>
                        <h2 class="heading">
                            123 Happy Street<br />
                            CoolCity - Pincode<br />
                            Region , Country<br />

                            Website : www.website.com<br />
                            E-mail : info@website.com<br />
                            Phone : +1 - 123456789
                        </h2>
                    </td>
                    <td rowspan="2" valign="top" align="right" style="padding:3mm;">
                        <table>
                            <tr><td>Invoice No : </td><td>11-12-17</td></tr>
                            <tr><td>Dated : </td><td>01-Aug-2011</td></tr>
                            <tr><td>Currency : </td><td>USD</td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Buyer</b> :<br />
                        Client Name<br />
                        Client Address
                        <br />
                        City - Pincode , Country<br />
                    </td>
                </tr>
            </table>


            <div id="content">

                <div id="invoice_body">
                    <table>
                        <tr style="background:#eee;">
                            <td style="width:8%;"><b>Sl. No.</b></td>
                            <td><b>Product</b></td>
                            <td style="width:15%;"><b>Quantity</b></td>
                            <td style="width:15%;"><b>Rate</b></td>
                            <td style="width:15%;"><b>Total</b></td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td style="width:8%;">1</td>
                            <td style="text-align:left; padding-left:10px;">Software Development<br />Description : Upgradation of telecrm</td>
                            <td class="mono" style="width:15%;">1</td><td style="width:15%;" class="mono">157.00</td>
                            <td style="width:15%;" class="mono">157.00</td>
                        </tr>         
                        <tr>
                            <td colspan="3"></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td colspan="3"></td>
                            <td>Total :</td>
                            <td class="mono">157.00</td>
                        </tr>
                    </table>
                </div>
                <div id="invoice_total">
                    Total Amount :
                    <table>
                        <tr>
                            <td style="text-align:left; padding-left:10px;">One  Hundred And Fifty Seven  only</td>
                            <td style="width:15%;">USD</td>
                            <td style="width:15%;" class="mono">157.00</td>
                        </tr>
                    </table>
                </div>
                <br />
                <hr />
                <br />

                <table style="width:100%; height:35mm;">
                    <tr>
                        <td style="width:65%;" valign="top">
                            Payment Information :<br />
                            Please make cheque payments payable to : <br />
                            <b>ABC Corp</b>
                            <br /><br />
                            The Invoice is payable within 7 days of issue.<br /><br />
                        </td>
                        <td>
                            <div id="box">
                                E &amp; O.E.<br />
                                For ABC Corp<br /><br /><br /><br />
                                Authorised Signatory
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <br />

        </div>

    </body>
</html>';
 

    //db
    private $db;
    private $DBH;
    //dynamic data 
    private $order_id;
    private $order;
    private $customer;
    //pdf default settings 
    private $row_height;
    private $max_row_per_page;

    function __construct($id) {
        $this->db = new dataBase();
        $this->DBH = $this->db->connect();

        $this->order_id = $id;
        $this->queryOrder();

        $this->row_height = 6;
        $this->max_row_per_page = 40;
    }

    public function queryProducts() {
        try {
            $stmt = $this->DBH->prepare('SELECT * FROM products p, orders_has_products op 
                                          WHERE op.orders_id = :id AND p.id = op.products_id');
            $stmt->execute(array('id' => $this->order_id));
            $products = $stmt->fetchAll();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        return $products;
    }

    public function queryCompany() {
        try {
            $stmt2 = $this->DBH->prepare('SELECT * FROM company_info');
            $stmt2->execute();
            $company = $stmt2->fetch();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        return $company;
    }

    public function queryCustomer() {
        try {
            $stmt3 = $this->DBH->prepare('SELECT * FROM customers WHERE id = :id');
            $stmt3->execute(array('id' => $this->order['customers_id']));
            $customer = $stmt3->fetch();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        $this->customer = $customer;
    }

    public function queryOrder() {
        try {
            $stmt4 = $this->DBH->prepare('SELECT * FROM orders WHERE id = :id');
            $stmt4->execute(array('id' => $this->order_id));
            $ord = $stmt4->fetch();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        $this->order = $ord;
    }

    public function createPDF() {
//        $products = $this->queryProducts();
//        $company = $this->queryCompany();
//        $this->queryCustomer();
//
//        //Create new pdf.
//        $pdf = new FPDF();
//
//        //Disable automatic page break.
//        $pdf->SetAutoPageBreak(true);
//
//        //First Page.
//        $pdf->AddPage();
//        $pdf->Image('../../../images/appleRedLogo.jpg', 5, 10, '30%');
//
//        //Page margins.
//        $y_axis = 76;
//
//        //Set font with color.
//        $pdf->SetFillColor(255, 255, 255);
//        $pdf->SetFont('Arial', 'B', 11);
//
//        //Set company info
//        $pdf->SetY(15);
//        $pdf->SetX(150);
//        $pdf->Cell('100%', 6, $company['name'], 0);
//        $pdf->SetY(15 + $this->row_height);
//        $pdf->SetX(150);
//        $pdf->Cell('100%', 6, gettext('tel').': ' . $company['telephone'], 0);
//        $pdf->SetY(15 + ($this->row_height * 2));
//        $pdf->SetX(150);
//        $pdf->Cell('100%', 6, gettext('piva').': '  . $company['piva'], 0);
//        $pdf->SetY(15 + ($this->row_height * 3));
//        $pdf->SetX(150);
//        $pdf->Cell('100%', 6, $company['address'], 0);
//
//        //Set customer info
//        $pdf->SetY(46);
//        $pdf->SetX(10);
//        $pdf->Cell('100%', 6, $this->customer['name'] . ' ' . $this->customer['surname'], 0);
//        $pdf->SetY(46 + $this->row_height);
//        $pdf->SetX(10);
//        if ($this->customer['piva'] != '') {
//            $pdf->Cell('100%', 6, gettext('piva').': ' . $this->customer['piva'], 0);
//            $pdf->SetY(46 + $this->row_height * 2);
//            $pdf->SetX(10);
//        } else {
//            $pdf->Cell('100%', 6, gettext('codf').': ' . $this->customer['cod_fis'], 0);
//            $pdf->SetY(46 + $this->row_height * 3);
//            $pdf->SetX(10);
//        }
//        $pdf->Cell('100%', 6, $this->customer['address'], 0);
//
//
//        //Prepare table for products detail.
//        $pdf->Ln();
//
//        $pdf->SetY(70);
//        $pdf->SetX(10);
//        $pdf->Cell('15%', 6, gettext('qty'), 1, 0, 'C');
//        $pdf->Cell('65%', 6, gettext('itm'), 1, 0, 'C');
//        $pdf->Cell('20%', 6, gettext('pr'), 1, 0, 'C');
//
//        $pdf->SetFont('Arial', 'I', 10);
//
//        //inizializzazone contatore e prezzo totale
//        $i = 0;
//        $tot = 0;
//        foreach ($products as $row) {
//            if ($i == $this->max_row_per_page) {
//                $pdf->AddPage();
//                $y_axis += $this->row_height;
//                $i = 0;
//            }
//
//            $pdf->SetY($y_axis);
//            $pdf->SetX(10);
//            $pdf->Cell('15%', 6, $row['quantity'], 1, 0, 'C');
//            $pdf->Cell('65%', 6, $row['name'], 1, 0, 'C');
//            $pdf->Cell('20%', 6, $row['sold_price'], 1, 0, 'C');
//
//            $pdf->SetTextColor(0, 0, 0);
//            //Go to next row
//            $y_axis += $this->row_height;
//            $i++;
//            $tot += $row['sold_price'] * $row['quantity'];
//        }
//
//        $pdf->SetY($i * 6 + 76);
//        $pdf->SetX(90);
//        $pdf->SetFont('Arial', 'B', 11);
//        $pdf->Cell('25%', 6, gettext('tot').' '.gettext('ord').': ', 0, 0, 'C');
//        $pdf->Cell('25%', 6, $tot, 1, 0, 'C');
//
//        //Convert the date.
//        $oDate = new DateTime($this->order['data']);
//        $sDate = $oDate->format("d-m-y");
//        //Create file
//        $fileName = $fileType . '-order' . $this->order_id . '-date' . $sDate . '.pdf';
//        $filePath = '../../../files/' . $fileType . '/' . $fileName;
//        chmod('../../../files/' . $fileType, 0777);
//        $pdf->Output($filePath, 'F');
        
        $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0); 
 
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list

        $mpdf->WriteHTML($html);
        
        //Convert the date.
        $oDate = new DateTime($this->order['data']);
        $sDate = $oDate->format("d-m-y");
        //Create files
        $ords = 'orders';
        $fileName = $ords . '-order' . $this->order_id . '-date' . $sDate . '.pdf';
        $filePath = '../../../files/' . $ords . '/' . $fileName;
        chmod('../../../files/' . $ords, 0777);
        $mpdf->Output($filePath, 'F');
        
        $inv = 'invoices';
        $fileName = $inv . '-order' . $this->order_id . '-date' . $sDate . '.pdf';
        $filePath = '../../../files/' . $inv . '/' . $fileName;
        chmod('../../../files/' . $inv, 0777);
        $mpdf->Output($filePath, 'F');
        
        return $filePath;

    }

    public function savePDF($filePath) {
        $save = array('path' => $filePath, 'id' => $this->order_id);
        try {
            $stmt6 = $this->DBH->prepare('INSERT INTO invoices (path, orders_id) 
                                           value (:path, :id)');
            $stmt6->execute($save);
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public function printTemplate() {
        require_once 'pdf_invoice_template.php';

        $mpdf = new mPDF('c', 'A4', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        $mpdf->WriteHTML($head.$css.$head_close.$html_template);
        $mpdf->Output();
    }

    public function getOrder_id() {
        return $this->order_id;
    }

    public function setOrder_id($order_id) {
        $this->order_id = $order_id;
    }

    public function getOrder() {
        return $this->order;
    }

    public function getCustomer() {
        return $this->customer;
    }

}

?>
