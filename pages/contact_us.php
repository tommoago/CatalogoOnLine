<?php

include '../templates/header.phtml';
?>

<script type="text/javascript" src="../scripts/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="../style/skin.css">
<script type="text/javascript" src="../../../scripts/form.customers.validation.js"></script>
<script type="text/javascript" src="../../../scripts/jquery.validate.js"></script>

<div id="content">

    <form action="contact.php" method="post" style="padding-left: 270px;" id="formcustomers" enctype="multipart/form-data">
        <div >
            Email:
        </div>
        <div >
            <input type="text" id="email" name="email"/>
        </div>
        <br>
        <div >
            Testo:
        </div>
        <div >
            <textarea id="textarea" name="question" rows="4" cols="50">
                        At w3schools.com you will learn how to make a website. We offer free tutorials in all web development technologies. 
            </textarea>
        </div>
        <input type="submit" value="invio"/>
    </form>

</div>
<?php

include '../templates/footer.phtml';
?>