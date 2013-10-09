<?php

$head = '<!DOCTYPE html>
<html>
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
                border: 1px solid #ccc;
                border-top: 1px solid #ccc;
                border-spacing:0;
                border-collapse: collapse; 
               
            }
         
            table td{
                border-right: 1px solid #ccc;
                border-bottom: 1px solid #ccc;
                font-size: 10px;
                padding: 2px
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
                <table class="t1" style="width:100%;">
                    <tr>
                        <td style="width:90mm;text-align:center" >
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
                        <td>Invoice n&#186;<p>1234567890</p></td>
                        <td>Date:<p>31.02.14</p></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width:90mm">Recipient:
                            <p>  <br>
                                <br>
                                <br>
                                
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="3">Description:<p></p></td>
                    </tr>
                    <tr>
                        <td>Buyer:<p></p></td>
                        <td>Cod.:<p></p></td>
                    </tr>
                    <tr>
                        <td>P.IVA:<p></p></td>
                        <td>Cod.Fiscale:<p></p></td>
                    </tr>
                    <tr>
                        <td>Causale trasporto:<p></p></td>
                        <td>Trasporto:<p></p></td>
                        <td>Banca d appoggio:<p></p></td>
                        <td>Valuta:<p></p></td>
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
                                <th>Tot.</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <!-- 
                                    </tr>
                                        <tr>
                                        <td colspan="3" style="text-align:right">Tot. Q.ty:</td>
                                        <td></td>
                                        <td colspan="4" style="text-align:right">TOT.</td>
                                        <td></td>
                                    </tr>
                                -->
                        </table>
                        <div id="invoice_total">

                            <table>
                                <tr>
                                    <td style="width:40%;text-align:left; padding-left:10px;"> Total Items:</td>
                                    <td style="width:10%;font-family:Courier"></td>
                                    <td style="width:35%;text-align:left; padding-left:10px;"> Total amount:</td>
                                    <td style="width:5%;font-family:Courier">EUR</td>
                                    <td style="width:10%;font-family:Courier" class="mono"></td>
                                </tr>
                            </table>
                        </div>

                    </div>

                    <br />

                </div>
                

                </body>
                </html>';
?>
