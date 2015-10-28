$(function(){
	$('#loginBtn').click(function() {
			var form_data = {
								username : $('#username').val(),
								Password : $('#Password').val()
							};
			$.ajax({
						url: js_base_path+"home/login",
						type: 'POST',
						async : false,
						data: form_data,
						success: function(msg) {
													if (msg == 1)
													{
														
														location.reload(); 
													}
													else
													{
														$('#errorDiv').html(msg);
													}
												}
				});
			return false;
	});

	$('#patientLoginBtn').click(function() {
			var form_data = {
								patientusername : $('#patientusername').val(),
								patientpasscode : $('#patientpasscode').val()
							};
			$.ajax({
						url: js_base_path+"patient/login",
						type: 'POST',
						async : false,
						data: form_data,
						success: function(msg) {
													if (msg == 1)
													{
														
														location.reload(); 
													}
													else
													{
														$('#errorDiv').html(msg);
													}
												}
				});
			return false;
	});

});