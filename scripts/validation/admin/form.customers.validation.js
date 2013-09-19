$(document).ready(function() {
	$("#formcustomers").validate({
                ignore: ".ignore",
		rules : {
			name : "required",
			surname : "required",
			address : "required",
			email : {
				required : true,
				email : true
			},
			telephone : {
				digits : true,
				required : true
			},
			password : "required",
		},
		messages : {
			name : " required",
			surname : " required",
			address : " required",
			email : " email not valid",
			telephone : " telephone not valid",
			password : " required",
		}
	});
});
