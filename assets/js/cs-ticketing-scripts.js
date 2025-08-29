jQuery(document).ready(function($) {
    
    current_page = $('#current_page').val();

	$('main').on('click', '.mobile-menu', function(e) {
		e.preventDefault();
		$('main').toggleClass('show-menu');
	});
    
	$('#tblIssues').DataTable({
		processing: true,
		serverSide: true,
		serverMethod: "POST",
		ordering: false,
    	bInfo: false,
    	ajax: base_url + "main/get_issues_DT/" + current_page,
    	columns: [
    		{
                data: 'ticket',
                orderable: false
            },
            {
                data: 'category',
                orderable: false
            },
            {
                data: 'username',
                orderable: false
            },
            {
                data: 'lastname',
                orderable: false
            },
            {
                data: 'firstname',
                orderable: false
            },
            {
                data: 'middlename',
                orderable: false
            },
            {
                data: 'channel',
                orderable: false
            },
            {
                data: 'email',
                orderable: false
            },
            {
                data: 'assignedto',
                orderable: false
            },
            {
                data: 'status',
                orderable: false
            },
            {
                data: 'datereported',
                orderable: false
            }
        ]
	});
  
    $('#tblIssues').on('click', '.btn-resolve', function(e) {
		e.preventDefault();
		msw_ticket = $(this).closest("tr").find("td:eq(0) > a").html();

		$("#msw-ticket-modal").html(msw_ticket);

		$(this).html('<i class="fa fa-spinner fa-spin"></i>');
		
		//get ticket details
		$.ajax({
            method:"POST",
            url:base_url+"/navigation/get_resolved_ticket_details",
            method:"POST",
            dataType: 'json',
		    data: "msw_ticket="+msw_ticket,
            success: function(data) {
                
            	$("#resolved-modal .ticket-details").html(data.details);
            	/*$("#resolved-modal #frmResolve select[name=cat_sel]").html(data.category);*/
            	$("#resolved-modal #frmResolve input[name=ticket]").val(msw_ticket);

    			$('#tblIssues .btn-resolve').html('<i class="fa fa-check"></i>');
    			
    			if(data.sda_stat == 1){
    			    $("#resolved-modal #frmResolve #reso_csa").attr('checked',true);
    			    $("#resolved-modal #frmResolve #reso_ama").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_onsite").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_cms").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_fra").attr('checked',false);
    			}else if(data.sda_stat == 2){
    			    $("#resolved-modal #frmResolve #reso_csa").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_ama").attr('checked',true);
    			    $("#resolved-modal #frmResolve #reso_onsite").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_cms").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_fra").attr('checked',false);
    			}else if(data.sda_stat == 3){
    			    $("#resolved-modal #frmResolve #reso_csa").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_ama").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_onsite").attr('checked',true);
    			    $("#resolved-modal #frmResolve #reso_cms").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_fra").attr('checked',false);
    			}else if(data.sda_stat == 4){
    			    $("#resolved-modal #frmResolve #reso_csa").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_ama").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_onsite").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_cms").attr('checked',true);
    			    $("#resolved-modal #frmResolve #reso_fra").attr('checked',false);
    			}else if(data.sda_stat == 5){
    			    $("#resolved-modal #frmResolve #reso_csa").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_ama").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_onsite").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_cms").attr('checked',false);
    			    $("#resolved-modal #frmResolve #reso_fra").attr('checked',true);
    			}
    			
    			$("#resolved-modal #frmResolve #completed_by").text(data.dept_assignee);
    			
    			$("#resolved-modal #frmResolve input[name=completed_id]").val(data.completed_id);
    			
    			$("#resolved-modal #frmResolve input[name=completed_dept]").val(data.dept_assignee);
    			
    			$("#resolved-modal #frmResolve input[name=mainsub]").val(data.mainsub);
    			
    			$("#resolved-modal #frmResolve input[name=subsub]").val(data.subsub);
    			
    			$("#resolved-modal #frmResolve input[name=outletname]").val(data.outletname);
    			
    			$('#resolved-modal').modal('show');
            },
            error:function(data) {
                alert("Please contact the developer and send the following error message");
                alert(JSON.stringify(data));
            }

        });
	});
	
	$('body').on('submit', '#resolved-modal #frmResolve, .ticket-details-wrapper #frmResolvedTicket', function(e) {
	    e.preventDefault();
	    
	    var formData = new FormData($(this)[0]);
	    
	    $.rconfirm({
	        title: "Resolve Issue",
	        message: "Are you sure you want to resolve this ticket?",
	        buttons: {
	            'Yes': {
	                action: function() {
	                    $('#resolved-modal').modal('hide');
	                    $.rloader();
	                    $.ajax({
	                        method: "POST",
	                        url: base_url + "/navigation/resolve_ticket",
	                        contentType: false,
	                        cache: false,
	                        processData: false,
	                        data: formData,
	                        success: function(response) {
	                            var data = JSON.parse(response);
	                            if(data.status) {
	                                $.ralert('Success', data.response, 'success', 'Close', function(){ window.location = base_url; });
	                            } else {
	                                $.ralert('Error', data.response, 'error');
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
    
    $(".ticket-details-wrapper").on('change', '.ticket-header #cb-status', function(e) {
	    e.preventDefault();
	    change_ticket_stat($(this).val());
	});
	
	function change_ticket_stat(stat){
        if(stat == 'on-hold') {
            $('.ticket-details-wrapper .status-card').slideUp(800);
            $('.ticket-details-wrapper .card-on-hold').slideDown(800);
    
        } else if(stat == 'cancel') {
            $('.ticket-details-wrapper .status-card').slideUp(800);
            $('.ticket-details-wrapper .card-cancel').slideDown(800);
    
        } else if(stat == 'resolve') {
            $('.ticket-details-wrapper .status-card').slideUp(800);
            $('.ticket-details-wrapper .card-resolve').slideDown(800);
    
        } else if(stat == 'in-progress'){
            $('.ticket-details-wrapper .status-card').slideUp(800);
    
            
            var msw_tix = $('#msw_tix').val();
            var old_status = $('#old_status').val();
            var new_status = stat;
            
            $.ajax({
    	        method: "POST",
    	        url: base_url + "navigation/inProgress",
    	        data: {msw_tix: msw_tix, old_status: old_status, new_status: new_status},
    	        success: function(response) {
    	            var data = JSON.parse(response);
    	            if(data.status) {
    	                $.ralert('Success', data.response, 'success', 'Close', function(){window.location.reload();})
    	            } else {
    	                $.ralert('Error', data.response, 'error');
    	            }
    	        }
    	    });
    	    
        } else if(stat == 're-open') {
            $('.ticket-details-wrapper .status-card').slideUp(800);
            
            var msw_tix = $('#msw_tix').val();
            
           $.ajax({
    	        method: "POST",
    	        url: base_url + "navigation/reOpen",
    	        data: {msw_tix: msw_tix},
    	        success: function(response) {
    	            var data = JSON.parse(response);
    	            if(data.status) {
    	                $.ralert('Success', data.response, 'success', 'Close', function(){window.location = base_url})
    	            } else {
    	                $.ralert('Error', data.response, 'error');
    	            }
    	        }
    	    });
    	    
        } else {
            $('#location-group').css("display", "block");
            $('.ticket-details-wrapper .status-card').slideUp(800);
        }
    }
    
    $('body').on('click', '.btn-submit-onhold', function(e) {
		e.preventDefault();
		
		var reason_txt  = $('#reason_txt').val();
        var onhold_id   = $('#onhold_id').val();
        var old_status  = $('#old_status').val();
        
        $.ajax({
	        method: "POST",
	        url: base_url + "navigation/onHold",
	        data: {onhold_id: onhold_id, reason_txt: reason_txt, old_status: old_status},
	        success: function(response) {
	            var data = JSON.parse(response);
	            if(data.status) {
	                $.ralert('Success', data.response, 'success', 'Close', function(){window.location.reload();})
	            } else {
	                $.ralert('Error', data.response, 'error');
	            }
	        }
	    });
        
	});
	
	$('body').on('click', '.btn-submit-cancel', function(e) {
		e.preventDefault();
		
		var reason_txt2 = $('#reason_txt2').val();
        var cancel_id = $('#cancel_id').val();
        var old_status  = $('#old_status').val();
        
        $.ajax({
	        method: "POST",
	        url: base_url + "navigation/cancelTicket",
	        data: {cancel_id: cancel_id, reason_txt2: reason_txt2, old_status: old_status},
	        success: function(response) {
	            var data = JSON.parse(response);
	            if(data.status) {
	                $.ralert('Success', data.response, 'success', 'Close', function(){window.location.reload();})
	            } else {
	                $.ralert('Error', data.response, 'error');
	            }
	        }
	    });
        
	});
	
	$(".ticket-details-wrapper").on('change', '.ticket-header #cb-location', function(e) {
	    e.preventDefault();
	    var sda = $(this).val();
	    var ticket = $('#msw_tix').val();
	    
	    $.ajax({
	        method: "POST",
	        url: base_url + "navigation/assignLocation",
	        data: {ticket: ticket, sda: sda},
	        success: function(response) {
	            var data = JSON.parse(response);
	            if(data.status) {
	                $.ralert('Success', data.response, 'success', 'Close', function(){window.location.reload();})
	            } else {
	                $.ralert('Error', data.response, 'error');
	            }
	        }
	    });
	    
	});
    
	$('#tblReports').DataTable({
		processing: true,
		serverSide: true,
		serverMethod: "POST",
		ordering: false,
    	bInfo: false,
    	ajax: base_url + "navigation/get_reports_DT",
    	columns: [
    		{
                data: 'ticket',
                orderable: false
            },
            {
                data: 'cat_label',
                orderable: false
            },
            {
                data: 'subcat_id',
                orderable: false
            },
            {
                data: 'outlet_name',
                orderable: false
            },
            {
                data: 'assigned_to',
                orderable: false
            },
            {
                data: 'created_at',
                orderable: false
            },
            {
                data: 'resolved_date',
                orderable: false
            },
            {
                data: 'resolution_type',
                orderable: false
            },
            {
                data: 'status',
                orderable: false
            }
        ]
	});
    
    $('#filter-reports').on('click',function(){
       redraw_table();
    });
    
    function redraw_table(){
		$('#tblReports').dataTable().fnDestroy();
		draw_table();
		redraw_graph();
	}
	
	if($('#rep_chart').length){
        
        var chart = new CanvasJS.Chart("rep_chart", {
                	exportEnabled: true,
                	animationEnabled: true,
                	title:{
                		text: "Overall Resolved Tickets"
                	},
                	axisX: {
                		 interval: 1
                	},
                	axisY2:{
                        interlacedColor: "rgba(1,77,101,.2)",
                        gridColor: "rgba(1,77,101,.1)",
                        title: "Number of Tickets"
                    },
                	toolTip: {
                		shared: true
                	},
                	legend:{
                		cursor: "pointer",
                		itemclick: toggleDataSeries
                	},
                	data: [{
                		type: "stackedBar",
                		name: "CSA",
                		showInLegend: "true",
                		xValueFormatString: "DD, MMM",
                		yValueFormatString: "#,##0",
                		dataPoints: []
                	},
                	{
                		type: "stackedBar",
                		name: "AMA",
                		showInLegend: "true",
                		xValueFormatString: "DD, MMM",
                		yValueFormatString: "#,##0",
                		dataPoints: []
                	},{
                		type: "stackedBar",
                		name: "RDA",
                		showInLegend: "true",
                		xValueFormatString: "DD, MMM",
                		yValueFormatString: "#,##0",
                		dataPoints: []
                	},{
                		type: "stackedBar",
                		name: "CMS",
                		showInLegend: "true",
                		xValueFormatString: "DD, MMM",
                		yValueFormatString: "#,##0",
                		dataPoints: []
                	},{
                		type: "stackedBar",
                		name: "FRA",
                		showInLegend: "true",
                		xValueFormatString: "DD, MMM",
                		yValueFormatString: "#,##0",
                		dataPoints: []
                	}]
                });
                chart.render();
        
                redraw_table();
                redraw_graph();
        
    }
	
	function redraw_graph(){
        
        var outlet_code = $('#outlet_code').val();
        var ticket_category = $('#ticket_category').val();
        var ticket_resolution = $('#ticket_resolution').val();
        var startdate = $('#startdate').val();
        var enddate = $('#enddate').val();
        
        $.ajax({
            method:"POST",
            url:base_url+"navigation/redraw_graph",
            data: {
                'outlet_code': outlet_code,
    			'ticket_category': ticket_category, 
    			'ticket_resolution': ticket_resolution, 
    			'startdate': startdate, 
    			'enddate': enddate
            },
            success: function(resp)
            {   
                var d =  jQuery.parseJSON(resp);
                var arr_sda = [];
                var arr_ama = [];
                var arr_online = [];
                var arr_cms = [];
                var arr_fra = [];
                
                $.each(d, function(key, value) {
                      $.each(value, function(key2, value2) {
                          if(key == 'csa'){
                              
                                arr_sda.push({
                                    y: parseInt(value2),
                                    label: key2
                                  });
                                 
                          }else if(key == 'ama'){
                               arr_ama.push({
                                    y: parseInt(value2),
                                    label: key2
                                  });
                          }else if(key == 'onsite'){
                               arr_online.push({
                                    y: parseInt(value2),
                                    label: key2
                                  });
                          }else if(key == 'cms'){
                               arr_cms.push({
                                    y: parseInt(value2),
                                    label: key2
                                  });
                          }else if(key == 'fra'){
                               arr_fra.push({
                                    y: parseInt(value2),
                                    label: key2
                                  });
                          }
                      });
                  });
                  
                chart.options.data[0].dataPoints = arr_sda;
                chart.options.data[1].dataPoints = arr_ama;
                chart.options.data[2].dataPoints = arr_online;
                chart.options.data[3].dataPoints = arr_cms;
                chart.options.data[4].dataPoints = arr_fra;
	            chart.render();
               
            },
            error:function(data)
            {
                alert("Please contact the developer and send the following error message");
                
            }

        });
        
    }
	
	function draw_table(){
        var outlet_code = $('#outlet_code').val();
        var ticket_category = $('#ticket_category').val();
        var ticket_resolution = $('#ticket_resolution').val();
        var startdate = $('#startdate').val();
        var enddate = $('#enddate').val();
        
        $('#tblReports').DataTable({
    		processing: true,
    		serverSide: true,
    		serverMethod: "POST",
    		ordering: false,
        	bInfo: false,
            ajax: {
    				'url': base_url + "navigation/get_reports_DT",
    				'data': {
    				    'outlet_code': outlet_code,
    				    'ticket_category': ticket_category, 
    				    'ticket_resolution': ticket_resolution, 
    				    'startdate': startdate, 
    				    'enddate': enddate
    				}
    			},
            columns: [
        		{
                    data: 'ticket',
                    orderable: false
                },
                {
                    data: 'cat_label',
                    orderable: false
                },
                {
                    data: 'subcat_id',
                    orderable: false
                },
                {
                    data: 'outlet_name',
                    orderable: false
                },
                {
                    data: 'assigned_to',
                    orderable: false
                },
                {
                    data: 'created_at',
                    orderable: false
                },
                {
                    data: 'resolved_date',
                    orderable: false
                },
                {
                    data: 'resolution_type',
                    orderable: false
                },
                {
                    data: 'status',
                    orderable: false
                }
            ]
            
        });
    }
    
    //resolution type radio - 06/03/2024
    $('.rdo_type' ).click(function(){
    if ($(this).is(':checked'))
        {
          var rdo_val = $(this).val();
          $("#cb-location option[value="+rdo_val+"]").prop('selected', 'selected');
        }
      });
	
});

function toggleDataSeries(e) {
    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    }
    else {
        e.dataSeries.visible = true;
    }
    x.render();
}

/*notes functions*/
$('body').on('click', '.btn-edit-note', function(e) {
    e.preventDefault();
    var target = $(this).attr('target');
    var note = $(this).closest('.notes').find('.note_body').text();
    
    $('#frm-notes input[name=note_id]').val(target);
    $('#frm-notes textarea[name=notes]').val(note);
});


$('#frm-notes').on('click', 'button[type=reset]', function(e) {
    $('#frm-notes input[name=remarks_txt]').val('');
});

$('body').on('click', '.btn-submit-notes', function(e) {
	e.preventDefault();
	var notes = $('#notes').val();
    var note_id = $('#note_id').val();
    var note_ticket_id = $('#note_ticket_id').val();
    
    $.ajax({
        method: "POST",
        url: base_url + "navigation/addTicketNotes",
        data: {note_ticket_id: note_ticket_id, note_id: note_id, notes: notes},
        success: function(response) {
            var data = JSON.parse(response);
            if(data.status) {
                $.ralert('Success', data.response, 'success', 'Close', function(){window.location.reload();})
            } else {
                $.ralert('Error', data.response, 'error');
            }
        }
    });
    
});

/*click filters*/
function redraw_issues_table(n){
    
    var status_filter = n;
    
    $('#tblIssues').DataTable({
	processing: true,
	serverSide: true,
	serverMethod: "POST",
	ordering: false,
	bInfo: false,
	ajax: {
			'url': base_url + "navigation/get_issues_DT/" + current_page,
			'data': {
			    'status_filter': status_filter
			}
    	},
	columns: [
		{
            data: 'ticket',
            orderable: false
        },
        {
            data: 'cat_label',
            orderable: false
        },
        {
            data: 'subcat_id',
            orderable: false
        },
        {
            data: 'outlet_name',
            orderable: false
        },
        {
            data: 'assigned_to',
            orderable: false
        },
        {
            data: 'ticket_status',
            orderable: false
        },
        {
            data: 'created_at',
            orderable: false
        },
        {
            data: 'modified_at',
            orderable: false
        },
        {
            data: 'action',
            orderable: false
        }
    ]
});
}


$('#header-in-progress').on('click', function() {
   $('#tblIssues').dataTable().fnDestroy();
   redraw_issues_table(1);
});

$('#header-on-hold').on('click', function() {
   $('#tblIssues').dataTable().fnDestroy();
   redraw_issues_table(2);
});

$('#header-cancelled').on('click', function() {
   $('#tblIssues').dataTable().fnDestroy();
   redraw_issues_table(3);
});

$('#header-resolved').on('click', function() {
   $('#tblIssues').dataTable().fnDestroy();
   redraw_issues_table(4);
});

