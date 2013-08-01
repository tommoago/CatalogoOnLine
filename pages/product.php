<?php
include 'header.php';
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#mycarousel').jcarousel();
	}); 
</script>
<div id="content">
	<?php
	include 'menu.php';
	?>
	<div>
		<img src="http://static.flickr.com/57/199481087_33ae73a8de_s.jpg" width="75" height="75" alt="" />
		<br>
		<b>Nome:</b>
		<p>
			Lanterna cinese
		</p>
		<b>Descrizione:</b>
		<p>
			Lanterna prodotta in cina
		</p>
		<b>Codice:</b>
		<p>
			0000000001
		</p>
		<b>Prezzo:</b>
		<p>
			Gratis
		</p>
	</div>
</div>
<?php

include 'footer.php';
?>