$(document).ready(function() {
	$("#formproduct").validate({
		rules : {
			name : "required",
			descr : "required",
			w_price : {
				required : true,
				number : true
			},
			r_price : {
				required : true,
				number : true
			},
			s_price : {
				required : true,
				number : true
			},
			p_price : {
				required : true,
				number : true
			},
			cod : "required",
			barcode : {
				digits : true,
				required : true
			},
			s_qty : {
				digits : true,
				required : true
			},
			p_qty : {
				digits : true,
				required : true
			},
			c_qty : {
				digits : true,
				required : true
			},
		},
		messages : {
			name : " name required ",
			descr : " description required ",
			w_price : " required",
			r_price : " required",
			s_price : " required",
			p_price : " required",
			cod : " code required ",
			barcode : " barcode required ",
			s_qty : " required",
			p_qty : " required",
			c_qty : " required",
		}
	});
});
