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
		<div class="prod">
			<img src="http://static.flickr.com/57/199481087_33ae73a8de_s.jpg" width="75" height="75" alt="" style="float:left;" />
			<div style="float: left; padding-left:50px; ">
				<b>Nome:</b>
				<p>
					Lanterna cinese
				</p>
				<b>Descrizione:</b>
				<p>
					Lanterna prodotta in cina
				</p>
			</div>
			<div style="float: left; padding-left:50px;">
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
		<div class="prod">
			<img src="http://static.flickr.com/57/199481087_33ae73a8de_s.jpg" width="75" height="75" alt="" style="float:left;" />
			<div style="float: left; padding-left:50px; ">
				<b>Nome:</b>
				<p>
					Lanterna cinese
				</p>
				<b>Descrizione:</b>
				<p>
					Lanterna prodotta in cina
				</p>
			</div>
			<div style="float: left; padding-left:50px;">
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

	</div>
</div>
<?php

include 'footer.php';
?>