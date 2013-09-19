$(document).ready(function() {
	$("#formcontact").validate({
		rules : {
			email : {
				required : true,
				email : true
			},
			 question : {
				required : true,
				minlength : 20
			},
		},
		messages : {
			name : " required",
			question : " required (at least 20 character)."
		}
	});
});
