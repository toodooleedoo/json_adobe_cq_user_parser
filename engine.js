$( document ).ready(function() {
	$('#userForm').submit(function() {
		ajaxy('prod','#output');
		return false;
	});
	alert('hi');
});
function ajaxy(param_,output_) { 
	$.ajax({
		data: param_,
		url: "call.php",
		timeout: 10000,
		statusCode: {
			200: function(response) { 
				$(output_).html(response);
			},
			202: function(response) { 
				$(output_).html('allowed');
			},
			203: function(response) { 
				$(output_).html('denied');
			},
			210: function(response) { 
				$(output_).html('User not found');
			}
		},
		error: function() {
			$(output_).html('error');
		},
		beforeSend: function(){
			$(output_).html("processing");	
		},
	});
	return false;
}
