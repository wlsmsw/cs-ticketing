jQuery(document).ready(function($) {

    
    $('#frmRegister').on('submit', function(e) {
 		e.preventDefault();
 		var formData = new FormData($(this)[0]);

 		$.rconfirm({
 			title: "Send Ticket",
 			message: "Continue sending ticket to MSW Customer Service?",
 			buttons: {
 				'Yes': {
 					action: function() {
 						$.rloader();
 						$.ajax({
 							method: "POST",
 							url: base_url + "ticket/submitWebformTicket",
 							contentType: false,
 							cache: false,
 							processData: false,
 							data: formData,
 							success: function(response) {
 								var data = JSON.parse(response);
 								if(data.status) {
 									$.ralert("Success", data.response, 'success', "Close", function(){ window.location.reload(); });
 								} else {
 									$.ralert("Error", data.response, 'error');
 								}
 								$.rloader.hide();
 							}
 						});
 					}
 				},
 				'No': {
 					class: 'button-default'
 				}
 			}
 		});
 	});
    
    
    
});