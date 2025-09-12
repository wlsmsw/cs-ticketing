jQuery(document).ready(function($) {

    
    $('#frmRegister').on('submit', function(e) {
 		e.preventDefault();
 		var formData = new FormData($(this)[0]);
 		
 		// Transform field names for Laravel backend compatibility
 		var laravelData = new FormData();
 		laravelData.append('username', formData.get('uname'));
 		laravelData.append('firstname', formData.get('fname'));
 		laravelData.append('lastname', formData.get('lname'));
 		laravelData.append('middlename', formData.get('mname'));
 		laravelData.append('category', formData.get('category'));
 		laravelData.append('channel', formData.get('channel'));
 		laravelData.append('email', formData.get('email'));
 		laravelData.append('description', formData.get('description'));
 		if(formData.get('upload_file')) {
 			laravelData.append('attachment', formData.get('upload_file'));
 		}

 		$.rconfirm({
 			title: "Send Ticket",
 			message: "Continue sending ticket to MSW Customer Service?",
 			buttons: {
 				'Yes': {
 					action: function() {
 						$.rloader();
 						$.ajax({
 							method: "POST",
 							url: "https://api.mswsites.com/cs-helpdesk/api/v1/tickets",
 							contentType: false,
 							cache: false,
 							processData: false,
 							data: laravelData,
 							success: function(response) {
 								// Laravel returns different response format
 								if(response.success) {
 									$.ralert("Success", response.message || "Your ticket has been submitted successfully!", 'success', "Close", function(){ window.location.reload(); });
 								} else {
 									$.ralert("Error", response.message || "Failed to submit ticket", 'error');
 								}
 								$.rloader.hide();
 							},
 							error: function(xhr, status, error) {
 								console.error('Webform submission error:', error);
 								$.ralert("Error", "Failed to submit ticket. Please try again.", 'error');
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