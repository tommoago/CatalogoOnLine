<?php

include 'data_Base.php';
include $_SERVER['DOCUMENT_ROOT'] . '/catalogoonline/vendor/mpdf/mpdf.php';

class PrintOrder {

    //db
    private $db;
    private $DBH;
    //dynamic data 
    private $order_id;
    private $order;
    private $customer;
    private $inv_number;
    private $inv_date;

    function __construct($id) {
        $this->db = new data_Base();
        $this->DBH = $this->db->connect();

        $this->order_id = $id;
        $this->queryOrder();
        $this->inv_date = date('d-m-y');
    }

    public function queryProducts() {
        try {
            $stmt = $this->DBH->prepare('SELECT * FROM products p, orders_has_products op 
                                          WHERE op.orders_id = :id AND p.id = op.products_id');
            $stmt->execute(array('id' => $this->order_id));
            $products = $stmt->fetchAll();
            foreach ($products as &$row) {
                if (strlen($row['description']) > 150)
                    $row['description'] = substr($row['description'], 0, 80) . '...';

                $stmtImg = $this->DBH->prepare('SELECT * FROM product_images WHERE products_id = :id');
                $stmtImg->execute(array('id' => $row['id']));
                $imm = $stmtImg->fetch();

                $row['image'] = $imm['path'];
            }
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

    public function createPDF($type) {
        //create new PDF 
        $mpdf = new mPDF('c', 'A4', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        if($type == 'order_details'){
            $mpdf->WriteHTML($this->processBody('ord'));
            $path = 'orders';
            $oDate = new DateTime($this->order['data']);
            //format date
            $sDate = $oDate->format("d-m-y");
        }else{
            $mpdf->WriteHTML($this->processBody('inv'));
            $path = 'invoices';
            $sDate = $this->inv_date;
        }
        
        //Create files
        $fileName = $path . '-' . $type . $this->order_id . '-date' . $sDate . '.pdf';
        $filePath = '../../../files/' . $path . '/' . $fileName;
        chmod('../../../files/' . $path, 0777);
        $mpdf->Output($filePath, 'F');
        return $filePath;
    }

    public function savePDF($filePath, $fileType) {
        $save = array('path' => $filePath, 'id' => $this->order_id);
        try {
            $stmt6 = $this->DBH->prepare('INSERT INTO '.$fileType.' (path, orders_id) 
                                           value (:path, :id)');
            $stmt6->execute($save);
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    private function processBody($type) {
        require 'pdf_invoice_template.php';
        $html = $head . $css . $head_close;
        $products = $this->queryProducts();
        $company = $this->queryCompany();
        $address = $this->queryAddress();
        $this->queryCustomer();
        $today = new DateTime();

        $html .= '<body>
        <div id="wrapper">

            <p style="text-align:center; font-weight:bold; padding-top:5mm;padding-bottom:5mm;">' . gettext($type) . '</p><br />
                <table>
                    <tr>
                        <td style="width:90mm;text-align:center" >
                            <h1 class="heading">' . $company['name'] . '</h1>
                            <h2 class="heading">
                                ' . $company['address'] . '<br />
                                ' . $company['zip'] . ' ' . $company['city'] . ' ' . $company['province'] . '<br />
                                ' . $company['country'] . '<br />
                                ' . $company['name'] . '<br />  
                                ' . $company['website'] . '<br />
                                ' . $company['telephone'] . '
                            </h2>
                        </td>
                        <td>
                        	<table class="t3">   
                        		<tr>';
                                                if ($type == 'ord') $html .= '<td style="width:65mm">' . gettext('ord') . ' n&#186;<p>' . $this->order_id . '</p></td>';
                                                else $html .= '<td style="width:65mm">' . gettext('inv') . ' n&#186;<p>' . $this->inv_number . '</p></td>';
                        			$html .= '<td style="width:25mm">' . gettext('date') . ':<p>' . $today->format("d-m-y") . '</p></td>
                    		</tr>
                    	</table>
                    	<table class="t3">
                    		<tr>
                      		  <td style="width:90mm;height:25mm">Recipient:
                            		<p>' . $this->customer['name'] . ' ' . $this->customer['surname'] . '<br>
                           		   ' . $address['street'] . '<br>
                          		   ' . $address['zip'] . ' ' . $address['city'] . ' ' . $address['province'] . '<br>
                                           ' . $address['country'] . '</p>
                                   </td>
                                </tr>
                        </table>
                    </tr>
                    <tr>
                    	<td>
                    		<table class="t2">
                    			<tr>
                    				<td style="width:45mm">' . gettext('cust') . ':<p>' . $this->customer['surname'] . '</p></td>
                    			  	<td style="width:45mm">' . gettext('code') . ':<p>' . $this->customer['id'] . '</p></td>
                     			 </tr>
                     			 <tr>
                         			<td style="width:45mm">' . gettext('piva') . ':<p>' . $this->customer['piva'] . '</p></td>
                         			<td style="width:45mm">' . gettext('codf') . ':<p>' . $this->customer['cod_fis'] . '</p></td>
                    			 </tr>
                    			 <tr>
                    			   	  <td style="width:45mm">Causale trasporto:<p>LOL</p></td>
                         			  <td style="width:45mm">Trasporto:<p>LOL</p></td>
                         		 </tr>
                         		 <tr>
                         		   	   <td style="width:45mm">Banca d&#146;appoggio:<p>LOL</p></td>
                         		   	   <td style="width:45mm">Valuta:<p>LOL</p></td>
                         		  </tr>
                 			</table>
                 		</td>
                 		<td>
                    		<table>
                    			  <tr class="t4">
                     			  	 <td style="width:90mm;height:35mm">' . gettext('descr') . ':<p>LOL</p></td>
                     			  </tr>
                 			</table>
                    	</td>
                    </tr>
			 </table>
                <div id="content_pdf">
                    <div id="invoice_body">
                        <table>
                            <tr style="background:#eee;">
                                <th>N&#186;</th>';
        if ($type == 'ord')
            $html .= '<th>' . gettext('img') . '</th>';
        $html .= '<th>' . gettext('prod') . ' ' . gettext('descr') . '</th>
                                <th>' . gettext('qty') . '</th>
                                <th>' . gettext('pr') . '</th>
                                <th>Discount</th>
                                <th>Discounted ' . gettext('pr') . '</th>
                                <th>' . gettext('vat') . '</th>
                                <th>' . gettext('tot') . '</th>
                            </tr>';
        $totQty = 0;
        $totOrd = 0;
        foreach ($products as $prod) {
            $discount = (($prod['retail_price'] - $prod['sold_price']) / $prod['retail_price']) * 100;
            $qty = $prod['quantity'] * $prod['sold_price'];
            
            $html.= '<tr>
                        <td>' . $prod['cod'] . '</td>';
            if ($type == 'ord')
                $html .= '<td><img src="../../' . $prod['image'] . '"></td>';
                $html .= '<td>' . $prod['description'] . '</td>
                          <td>' . $prod['quantity'] . '</td>
                          <td>' . $prod['retail_price'] . '</td>
                          <td>' . round($discount, 2) . '</td>
                          <td>' . $prod['sold_price'] . '</td>
                          <td>' . $prod['vat'] . '</td>
                          <td>' . round($qty, 2) . '</td>';
                
            $totQty += $prod['quantity'];
            $totOrd += $qty;
        }
        $html.= '</table>
            <div id="invoice_total">
                <table>
                    <tr>
                        <td style="width:40%;text-align:left; padding-left:10px;"> ' . gettext('tot') . ' ' . gettext('itms') . ':</td>
                        <td style="width:10%;font-family:Courier">' . $totQty . '</td>
                        <td style="width:35%;text-align:left; padding-left:10px;"> ' . gettext('tot') . ' ' . gettext('amt') . ':</td>
                        <td style="width:5%;font-family:Courier">EUR</td>
                        <td style="width:10%;font-family:Courier" class="mono">' . $totOrd . '</td>
                    </tr>
                </table>
            </div>
        </div>
        <br />
    </div>
</body>
</html>';
        return $html;
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
    
    public function setInv_number($inv_number) {
        $this->inv_number = $inv_number;
    }

    public function setInv_date($inv_date) {
        $this->inv_date = $inv_date;
    }

}

?>
