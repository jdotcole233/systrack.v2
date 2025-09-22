var client_id;

$(".update_client").hide();

$("#add_client").on("click", function (e) {
    swal({
        title: "Add Client",
        text: "Adding new client to Firmus-SysTrack",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $("#loading_progress").modal("show");

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            e.preventDefault();
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "/send_client_information/manager",
                data: $("#client-addition-forms").serialize(),
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    swal({
                        title: "Welcome to Firmus",
                        text: data.successful,
                        icon: "success",
                    });

                    var client_information =
                        '<tr id="client_row' +
                        data.Data_back.client_id +
                        ' " ><td>' +
                        data.Data_back.company_name +
                        "</td><td>" +
                        data.Data_back.email +
                        "</td><td>" +
                        data.Data_back.phone_number +
                        "</td><td>" +
                        data.Data_back.nationality +
                        "</td><td>" +
                        data.Data_back.location +
                        "</td></td>";

                    client_information +=
                        '<td><button class="btn btn-primary client_edit_info" value="  ' +
                        data.Data_back.client_id +
                        ' ">Edit</button></td><td> <button class="btn btn-danger client_delete_info" value=" ' +
                        data.Data_back.client_id +
                        '">Delete</button></td></tr>';

                    $("#table_body").append(client_information);
                    $("#client-addition-forms").trigger("reset");
                    $("#con-close-modal").modal("hide");
                },
                error: function (error) {
                    $("#loading_progress").modal("hide");
                    swal("Check to ensure neccessary fields are not blank");
                    // $.each(error,function(v,i){
                    // 	alert(v);
                    // });
                    //alert(error.status);
                },
            });
        } else {
            $("#loading_progress").modal("hide");
            swal({
                title: "Employee",
                text: "Employee not added",
                icon: "warning",
            });
        }
    });
});

$("#add_client_employee").on("click", function (e) {
    swal({
        title: "Add Client",
        text: "Adding new client to Firmus-SysTrack",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $("#loading_progress").modal("show");

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            e.preventDefault();
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "/send_client_information/employee",
                data: $("#client-addition-forms").serialize(),
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    swal({
                        title: "Welcome to Firmus",
                        text: data.successful,
                        icon: "success",
                    });

                    var client_information =
                        '<tr id="client_row' +
                        data.Data_back.client_id +
                        ' " ><td>' +
                        data.Data_back.company_name +
                        "</td><td>" +
                        data.Data_back.email +
                        "</td><td>" +
                        data.Data_back.phone_number +
                        "</td><td>" +
                        data.Data_back.nationality +
                        "</td><td>" +
                        data.Data_back.location +
                        "</td></td>";

                    client_information +=
                        '<td><button class="btn btn-primary client_edit_info" value="  ' +
                        data.Data_back.client_id +
                        ' ">Edit</button></td><td> <button class="btn btn-danger client_delete_info" value=" ' +
                        data.Data_back.client_id +
                        '">Delete</button></td></tr>';

                    $("#table_body").append(client_information);
                    $("#client-addition-forms").trigger("reset");
                    $("#con-close-modal").modal("hide");
                },
                error: function (error) {
                    $("#loading_progress").modal("hide");
                    swal("Check to ensure neccessary fields are not blank");
                    // $.each(error,function(v,i){
                    // 	alert(v);
                    // });
                    //alert(error.status);
                },
            });
        } else {
            $("#loading_progress").modal("hide");
            swal({
                title: "Employee",
                text: "Employee not added",
                icon: "warning",
            });
        }
    });
});

$("#datatable-buttons").on("click", ".client_edit_info", function (e) {
    client_id = $(this).attr("value");
    //  console.log(client_id)

    var url = "/client_edit_get_information/" + client_id;

    $.ajax({
        type: "GET",
        dataType: "json",
        url: url,
        success: function (data) {
            $("#field-1").val(data.company_name);
            $("#field-2").val(data.email);
            $("#field-3").val(data.phone_number);
            $("#field-4").val(data.location);
            $("#field-5").val(data.address);
            $("#country_check").val(data.nationality).change();
            $("#status_check").val(data.status).change();
            $("#field-6").val(data.company_name);
        },
        error: function () {},
    });

    $("#con-close-modal").modal("show");
    $(".add").hide();
    $(".update_client").show();
});

$(".update_client").on("click", function (e) {
    var url = "/client_edit_information/" + client_id;

    swal({
        title: "Are you sure?",
        text: "You want to update client information?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            //$('#loading_progress').modal('show');
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            e.preventDefault();

            $.ajax({
                method: "POST",
                dataType: "json",
                url: url,
                data: $("#client-addition-forms").serialize(),
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    swal({
                        title: "Clients Information",
                        text: data.message,
                        icon: "success",
                    });

                    var client_information =
                        '<tr id="client_row' +
                        data.datails.client_id +
                        ' " ><td>' +
                        data.datails.company_name +
                        "</td><td>" +
                        data.datails.email +
                        "</td><td>" +
                        data.datails.phone_number +
                        "</td><td>" +
                        data.datails.nationality +
                        "</td><td>" +
                        data.datails.location +
                        "</td></td>";

                    client_information +=
                        '<td><button class="btn btn-primary client_edit_info" value="  ' +
                        data.datails.client_id +
                        ' ">Edit</button> <button class="btn btn-danger client_delete_info" value=" ' +
                        data.datails.client_id +
                        '">Delete</button></td></tr>';

                    $("#client_row" + data.datails.client_id).replaceWith(
                        client_information
                    );

                    $("#con-close-modal").modal("hide");
					window.location.reload();
                },
                error: function () {
                    swal("Check to see essential fields are not blank");
                },
            });

            $("#client-addition-forms").trigger("reset");
            $(".add").show();
            $(".update_client").hide();
            $("#con-close-modal").modal("hide");
        } else {
            swal("Client not updated");
        }
    });
});

$("#table_body").on("click", ".client_delete_info", function (e) {
    var client_del_id = $(this).attr("value");

    var url_delete = "/client_delete_information/" + client_del_id;

    swal({
        title: "Are you sure?",
        text: "Once client is deleted, you will not be able to recover!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $("#loading_progress").modal("show");
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            e.preventDefault();

            $.ajax({
                method: "POST",
                url: url_delete,
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    $("#client_row" + client_del_id).remove();
                    swal("Client removed");
                },
                error: function () {
                    swal("error");
                },
            });
        } else {
            swal("Client Not deleted");
        }
    });
});

//populate new contact
// $.ajax({
// 	method:'GET',
// 	dataType: 'json',
// 	url: 'manager-clients',
// 	success : function (data){

// 		var client_information = '<tr> <th> <span class="avatar-sm-box bg-success">' + K
// 		+ '</span> </th> <td> <h5 class="m-0">' + data.data_info.company_name
// 		+ '</h5> <p class="m-0 text-muted font-13"><small>' + data.data_info.nationality
// 		+ '</small></p></td> <td>' + data.data_info.phone_number + '</td> <td>' +
// 		 data.data_info.location + '</td> <td> ' + data.data_info.email + '</td> </tr>';

// 		 $('#new_contact_det').append(client_information);

// 	},
// 	error: function (){
// 		swal('Error');
// 	}
// });

$(".close_btn").click(function () {
    $(".add").show();
    $(".update_client").hide();
    $("#client-addition-forms").trigger("reset");
});
