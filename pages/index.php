<?php
include '../templates/header.phtml';
include 'validation.php';
?>

<script type="text/javascript" src="../scripts/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../scripts/jquery.jcarousel.min.js"></script>
<link rel="stylesheet" type="text/css" href="../style/skin.css">
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#mycarousel').jcarousel();
	}); 
</script>
<div id="content">
	<?php
	include '../templates/menu.phtml';
	?>
	<center>
		<div style="height: 200px; width: 500px;">
			<ul id="mycarousel" class="jcarousel-skin-tango" >
				<li>
					<a href=""> <img src="http://static.flickr.com/66/199481236_dc98b5abb3_s.jpg" width="75" height="75" alt="" />
					<p>
						mela rossa
					</p> </a>
				</li>
				<li>
					<a href=""> <img src="http://static.flickr.com/75/199481072_b4a0d09597_s.jpg" width="75" height="75" alt="" />
					<p>
						mela verde
					</p> </a>
				</li>

				<li><img src="http://static.flickr.com/57/199481087_33ae73a8de_s.jpg" width="75" height="75" alt="" />
				</li>
				<li><img src="http://static.flickr.com/77/199481108_4359e6b971_s.jpg" width="75" height="75" alt="" />
				</li>
				<li><img src="http://static.flickr.com/58/199481143_3c148d9dd3_s.jpg" width="75" height="75" alt="" />
				</li>
				<li><img src="http://static.flickr.com/72/199481203_ad4cdcf109_s.jpg" width="75" height="75" alt="" />
				</li>
				<li><img src="http://static.flickr.com/58/199481218_264ce20da0_s.jpg" width="75" height="75" alt="" />
				</li>
				<li><img src="http://static.flickr.com/69/199481255_fdfe885f87_s.jpg" width="75" height="75" alt="" />
				</li>
				<li><img src="http://static.flickr.com/60/199480111_87d4cb3e38_s.jpg" width="75" height="75" alt="" />
				</li>
				<li><img src="http://static.flickr.com/70/229228324_08223b70fa_s.jpg" width="75" height="75" alt="" />
				</li>
			</ul>
		</div>
	</center>
</div>
<?php
include '../templates/footer.phtml';
?>