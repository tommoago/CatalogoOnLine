<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form action="insertProduct.php" method="post" style="padding-left: 270px;">
            <p>Name</p> <input type="text" name="name"/><br>

            <p>Description</p><input type="text" name="descr"/><br>

            <p>New</p><input type="checkbox" name="new" /><br>
            
            <p>Offer</p><input type="checkbox" name="offer" /><br>
            
            <p>Evidence</p><input type="checkbox" name="evidence" /><br>

            <p>Wholesale Price</p><input type="text" name="w_price"/><br>
            
            <p>Retail Price</p><input type="text" name="r_price"/><br>
            
            <p>Super Price</p><input type="text" name="s_price"/><br>
            
            <p>Purchase Price</p><input type="text" name="p_price"/><br>
            
            <p>Cod</p><input type="text" name="cod"/><br>
            
            <p>Barcode</p><input type="text" name="barcode"/><br>
            
            <p>Single Qty</p><input type="text" name="s_qty"/><br>
            
            <p>pack Qty</p><input type="text" name="p_qty"/><br>
            
            <p>Cardboard Qty</p><input type="text" name="c_qty"/><br>
            
            <p>Categoy</p>
            <select name="cat_id">
                <option value="1">lol</option>   
                <option value="4">hhh</option>   
            </select>

            <input type="submit" value="invio"/>

        </form>
    </body>
</html>
