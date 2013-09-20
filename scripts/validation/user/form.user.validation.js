$(document).ready(function() {
	$("#formuser").validate({
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
                        password2 : {
                            required: true,
                            equalTo: "#password"
                        },
                        agree: "required"
                        
		},
		messages : {
			name : " required",
			surname : " required",
			address : " required",
			email : " email not valid",
			telephone : " telephone not valid",
			password : " required",
                        password2 : " Passwords does not match.",
                        agree :"You must accept the term and conditions."
		}
	});
});
