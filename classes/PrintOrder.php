<?php

include 'fpdf.php';
include 'dataBase.php';
include $_SERVER['DOCUMENT_ROOT'].'/melarossa/vendor/mpdf/mpdf.php';

define('FPDF_FONTPATH', '../../../files/font/');

class PrintOrder {
    //db
    private $db;
    private $DBH;
    //dynamic data 
    private $order_id;
    private $order;
    private $customer;

    function __construct($id) {
        $this->db = new dataBase();
        $this->DBH = $this->db->connect();

        $this->order_id = $id;
        $this->queryOrder();
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
    
     public function queryAddress() {
        try {
            $stmt5 = $this->DBH->prepare('SELECT * FROM addresses WHERE id = :id');
            $stmt5->execute(array('id' => $this->order['addresses_id']));
            $adr = $stmt5->fetch();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        return $adr;
    }

    public function createPDF() {
        require_once 'pdf_invoice_template.php';
        $html = $head.$css.$head_close;
        $products = $this->queryProducts();
        $company = $this->queryCompany();
        $address = $this->queryAddress();
        $this->queryCustomer();
        
        //create new PDF
        $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0); 
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list

        //data template injecting
        $invDate = new DateTime();
        $html .= '<body>
        <div id="wrapper">

            <p style="text-align:center; font-weight:bold; padding-top:5mm;padding-bottom:5mm;">'.gettext('inv').'</p>
            <br />
            <table class="t1" style="width:100%;">
                <table>
                    <tr>
                        <td style="width:90mm;text-align:center" colspan="2" rowspan="3">
                            <h1 class="heading">'.$company['name'].'</h1>
                            <h2 class="heading">
                                '.$company['address'].'<br />
                                '.$company['zip'].' '.$company['city'].' '.$company['province'].'<br />
                                '.$company['country'].'<br />
                                '.$company['name'].'<br />
                                '.$company['website'].'<br />
                                '.$company['telephone'].'
                            </h2>
                        </td>
                        <td>'.gettext('inv').' n&#186;<p>1234567890</p></td>
                        <td>'.gettext('date').':<p>'.$invDate->format("d-m-y").'</p></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width:90mm">Recipient:
                            <p>  '.$this->customer['name'].'<br>
                                '.$address['street'].'<br>
                                '.$address['zip'].' '.$address['city'].' '.$address['province'].'<br>
                                '.$address['country'].'
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="3">'.gettext('descr').':<p>LOL</p></td>
                    </tr>
                    <tr>
                        <td>'.gettext('code').':<p>LOL</p></td>
                        <td>'.gettext('code').':<p>LOL</p></td>
                    </tr>
                    <tr>
                        <td>'.gettext('piva').':<p>'.$this->customer['piva'].'</p></td>
                        <td>'.gettext('codf').':<p>'.$this->customer['cod_fis'].'</p></td>
                    </tr>
                    <tr>
                        <td>Causale trasporto:<p>LOL</p></td>
                        <td>Trasporto:<p>LOL</p></td>
                        <td>Banca d appoggio:<p>LOL</p></td>
                        <td>Valuta:<p>LOL</p></td>
                    </tr>
                </table>

                <div id="content">
                    <div id="invoice_body">

                        <table>
                            <tr style="background:#eee;">
                                <th>N&#186;</th>
                                <th>img</th>
                                <th>Product description</th>
                                <th>Q.ty</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Discounted price</th>
                                <th>IVA</th>
                                <th>'.gettext('tot').'</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td><img src="http://campaign.odw.sony-europe.com/wm/new/img/xperia-z1/icon-xperia-z1_40x40-water.png"></td>
                                <td>prod</td>
                                <td>q.t&agrave;</td>
                                <td>prezzo listino</td>
                                <td>sconto</td>
                                <td>prezzo scontato</td>
                                <td>iva</td>
                                <td>importo</td>
                                <!-- 
                                    </tr>
                                        <tr>
                                        <td colspan="3" style="text-align:right">'.gettext('tot').' '.gettext('qty').':</td>
                                        <td>-SUM-</td>
                                        <td colspan="4" style="text-align:right">'.gettext('tot').'</td>
                                        <td>-SUM-</td>
                                    </tr>
                                -->
                        </table>
                        <div id="invoice_total">

                            <table>
                                <tr>
                                    <td style="width:40%;text-align:left; padding-left:10px;"> '.gettext('tot').' '.gettext('itms').':</td>
                                    <td style="width:10%;font-family:Courier">-SUM-</td>
                                    <td style="width:35%;text-align:left; padding-left:10px;"> '.gettext('tot').' '.gettext('amt').':</td>
                                    <td style="width:5%;font-family:Courier">EUR</td>
                                    <td style="width:10%;font-family:Courier" class="mono">157.00</td>
                                </tr>
                            </table>
                        </div>

                    </div>

                    <br />

                </div>

                </body>
                </html>';
        
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
