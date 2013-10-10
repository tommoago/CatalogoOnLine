<?php

$head = '<!DOCTYPE html>
    <head>
        <title>Print Invoice</title>';
$css = '<style>
            *{
                margin:0;
                padding:0;
                font-family:Arial;
                font-size:10pt;
                color:#000;
            }
            body{
                width:100%;
                font-family:Arial;
                font-size:10pt;
                margin:0;
                padding:0;
            }
            img {
                height: 30px;
                width: auto
            }
            p{
                margin:0;
                padding:0;
            }

            #wrapper{
                width:180mm;
                margin:0 15mm;
            }

            .page{
                height:297mm;
                width:210mm;
                page-break-after:always;
            }
            table{
                border-spacing:0;
                border-collapse: collapse; 

            }

            table td{
                border-bottom: 1px solid #ccc;
                font-size: 10px;
                padding: 0px
                border-right: 1px solid #ccc;
            }
            table .t2{
                border-spacing:0;
                border-collapse: collapse; 

            }

            table .t2 td{
                border-top: 1px solid #ccc;
                border-left: 1px solid #ccc;
                border-bottom: 0px solid #ccc;
                font-size: 10px;
                padding: 2px
            }
            table .t3{
                border-spacing:0;
                border-collapse: collapse; 

            }

            table .t3 td{
                border-top: 1px solid #ccc;
                border-right: 1px solid #ccc;
                border-left: 1px solid #ccc;
                border-bottom: 0px solid #ccc;
                font-size: 10px;
                padding: 2px;
                vertical-align: top;
                text-align:left
            }
            th {
			border-right: 1px solid #ccc;
            }
            p {
                font-size: 15px;
                font-family: Courier;
                margin-left: 10px
            }
            table.t1{
                height:50mm;
            }

            h1.heading{
                font-size:14pt;
                color:#000;
                font-weight:normal;
            }

            h2.heading{
                font-size:9pt;
                color:#000;
                font-weight:normal;
                padding: 5px
            }

            hr{
                color:#ccc;
                background:#ccc;
            }

            #invoice_body{
                height: 149mm;
            }

            #invoice_body , #invoice_total{   
                width:100%;
            }
            #invoice_body table , #invoice_total table{
                width:100%;
                border-left: 1px solid #ccc;
                border-top: 1px solid #ccc;

                border-spacing:0;
                border-collapse: collapse; 

                margin-top:5mm;
            }

            #invoice_body table td , #invoice_total table td{
                text-align:center;
                font-size:9pt;
                border-right: 1px solid #ccc;
                border-bottom: 1px solid #ccc;
                padding:2mm 0;
            }

            #invoice_body table td.mono  , #invoice_total table td.mono{
                font-family:monospace;
                text-align:right;
                padding-right:3mm;
                font-size:10pt;
            }

            #footer{   
                width:180mm;
                margin:0 15mm;
                padding-bottom:3mm;
            }
            #footer table{
                width:100%;
                border-left: 1px solid #ccc;
                border-top: 1px solid #ccc;

                background:#eee;

                border-spacing:0;
                border-collapse: collapse; 
            }
            #footer table td{
                width:25%;
                text-align:center;
                font-size:9pt;
                border-right: 1px solid #ccc;
                border-bottom: 1px solid #ccc;
            }
        </style>';
$head_close = '</head>';
$html_template = '<body>
        <div id="wrapper">

            <p style="text-align:center; font-weight:bold; padding-top:5mm;padding-bottom:5mm;">INVOICE</p>
            <br />
            <table>
                    <tr>
                        <td style="width:90mm;text-align:center">
                            <h1 class="heading">Mela Rossa</h1>
                            <h2 class="heading">
                                Via Uruguay, 2<br />
                                35100 Padova (PD)<br />
                                Italia<br />
                                www.website.com<br />
                                info@website.com<br />
                                +39 123456789
                            </h2>
                        </td>
                        <td>
                        	<table class="t3">   
                        		<tr>
                        			<td style="width:65mm">Invoice n&#186;<p>1234567890</p></td>
                        			<td style="width:25mm">Date:<p>31.02.14</p></td>
                        		</tr>
                        	</table>
                        	<table class="t3">
						<tr>
         			               <td style="width:90mm;height:25mm">Recipient:
            		                <p>  Gino Stecca<br>
           		                     Via della Busa, 7<br>
          		                     35010 Vigodarzere (PD)<br>
         		                       	 Italia
                            		 </p></td>
			          	</tr>  
			          </table>
                    </tr>
               	<tr>
                    	<td>
                     		<table class="t2">
                    			  <tr>
                     			  	 <td style="width:45mm">Buyer:<p>LOL</p></td>
                    			  	 <td style="width:45mm">Cod.:<p>LOL</p></td>
                     			   </tr>
                     			   <tr>
                         			 <td style="width:45mm">P.IVA:<p>LOL</p></td>
                         			 <td style="width:45mm">Cod.Fiscale:<p>LOL</p></td>
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
                    			  <tr class="t3">
                     			  	 <td style="width:90mm;height:33.5mm">Description:<p>LOL</p></td>
                     			  </tr>
                 			</table>
                    	</td>
                    </tr>
                </table>
                <div id="content_pdf">
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
                                <th>Tot.</th>
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
                        </table>
                        <div id="invoice_total">

                            <table>
                                <tr>
                                    <td style="width:40%;text-align:left; padding-left:10px;"> Total Items:</td>
                                    <td style="width:10%;font-family:Courier">-SUM-</td>
                                    <td style="width:35%;text-align:left; padding-left:10px;"> Total amount:</td>
                                    <td style="width:5%;font-family:Courier">EUR</td>
                                    <td style="width:10%;font-family:Courier" class="mono">157.00</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <br />
          	</div>
        </div>
    </body>';
?>
