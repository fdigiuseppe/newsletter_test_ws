$(document).ready(function () {
	$("#nwl_form").submit(function (event) {
		//alert("Handler for .submit() called.");
		event.preventDefault();

		$.ajax({
			type: 'post',
			url: 'handler.php',
			data: $('#nwl_form').serialize(),
			dataType: 'json',
			success: function (data) {
				//alert('form was submitted');
				console.log(data);
				if (data.status) {
					$('#nwl_form').trigger("reset");
					$("#success_message").fadeIn();
					setTimeout(function(){
						$("#success_message").fadeOut();
					}, 2500);
				}
				else {
					$("#error_message").fadeIn();
				}
			}
		});
		
	});
});