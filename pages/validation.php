<script>
	function keyCheck() {
		if (!(event.which == 13 || event.which == 116))
			event.preventDefault();
	}

	//alert("KeyCode = "+event.keyCode);
	document.onkeydown = keyCheck; 
</script>