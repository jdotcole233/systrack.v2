
//Automatically hides Update button when page loads.
$('.update_changes').hide();

//Global variable for employee ID.
var individual_id ;


/*------------------------------------------------------------------*
 * Gets, employee id from each row clicked						 	*
 * Populates modal form with information of employee from database 	*
 * Displays and hides Save and update button						*
 *------------------------------------------------------------------*/

$('table').on("click",".edit_btn",function(){
		 $('.save_changes').hide();
		 $('.update_changes').show();
		 $('.reset_password').show();
		 individual_id = $(this).attr('value');
		 var url = "/employee_in_update_record/" + individual_id;

		$.get(url,function(data){
			$('#field-1').val(data.first_name);
			$('#field-2').val(data.other_name);
			$('#field-3').val(data.last_name);
			$('#field-4').val(data.contact_number);
			$('#field-5').val(data.address);
			$('#field-6').val(data.company_email);
			$('#field-7').val(data.position).change();
			$('#field-8').val(data.gender).change();

		})

		$('#con-close-modal').modal('show');
});


/*------------------------------------------------------------------*
 * update function, gets selected employee details from the formm 	*
 * through the serialize method, and passes the informtion through 	*
 * the url to the database.											*
 *------------------------------------------------------------------*/

 	$('.update_changes').on('click',function(e){



	  swal({
              title: "Update Employee",
              text: "Update employee details",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            }).then((willDelete) => {
              if (willDelete) {

              $('#loading_progress').modal('show');

			$.ajaxSetup({
			            headers: {
			                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			            }
			        })

 			 		 e.preventDefault();

 					$.ajax({
			 			method:'POST',
			 			url:'/employee_in_update_record_user/' + individual_id,
			 			data: $("#employee_forms").serialize(),
			 			success: function(data){
             				 $('#loading_progress').modal('hide');
			 			    swal({
			 			    	title: "Employee Update",
			 			    	text: data.msg,
			 			    	icon: "success",
			 			    	button: "OK"
			 			    });
			 			    $('#con-close-modal').modal('hide');
			 			    $('#employee_forms').trigger('reset');
			 			    $('.save_changes').show();
			 			    $('.update_changes').hide();

			 			},
			 			error: function (){
             				 $('#loading_progress').modal('hide');
			 				swal("Essential fields cannot be left blank");
			 			}
			 		});
			 		}else{
              $('#loading_progress').modal('hide');
            swal({title: "Employee", text:"Employee details not updated", icon: "warning"});
        }
        });

 	});


$('.reset_password').click(function(){
	$.ajaxSetup({
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            }
	        })

		swal({
			  title: "Are you sure?",
			  text: "You are attempting to reset user password to default",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
              			$('#loading_progress').modal('show');
						$.ajax({
							type: 'POST',
							dataType:'json',
							url: '/reset_user_password/' + individual_id,
							success: function(data){

								$('#loading_progress').modal('hide');
								$('#con-close-modal').modal('hide');
			 			    	$('#employee_forms').trigger('reset');
			 			    	swal({
			 			    		title:'Success',
			 			    		text: 'Password reset Successfully',
			 			    		icon:'success'
			 			    	});
							},
							error: function(){
             				 $('#loading_progress').modal('hide');
								console.log('Error resetting password');
							}
						});

			 } else {
              $('#loading_progress').modal('hide');
			    swal("password resetted");
			  }
			});
});




	$('table').on("click",".employee_delete_info",function(e){
		var employee_del_id = $(this).attr('value');
		var url_delete = '/employee_delete_information/' + employee_del_id;

		swal({
			  title: "Are you sure?",
			  text: "Once employee is deleted, you will not be able to recover!",
			  icon: "Warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
              $('#loading_progress').modal('show');
			  	$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					}
				});

					e.preventDefault();

					$.ajax({
						method:'POST',
						url: url_delete,
						success : function(data){
              				$('#loading_progress').modal('hide');
							$('#employee_row' + employee_del_id).remove();
							swal("Employee file has been deleted successfully!", {
						      icon: "Success",
						    });
						},
						error : function(){
             			 $('#loading_progress').modal('hide');
							console.log("Error in deletion");
						}

					});

			  } else {
              $('#loading_progress').modal('hide');
			    swal("Employee Not deleted");
			  }
			});

	});





 /*------------------------------------------------------------------*
 * dismiss modal, set visible the save button and hides the update 	*
 * button, also clears the form elements                        	*
 *------------------------------------------------------------------*/

 	$('.close_emp_form').click(function(){
 		 $('.save_changes').show();
		 $('.update_changes').hide();
		 $('#employee_forms').trigger('reset');
		 $('.reset_password').hide();

 	});
