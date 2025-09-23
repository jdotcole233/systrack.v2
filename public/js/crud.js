var intervalMessage = null;
var datalist = "";
var options = "";
var optionsarray = "";
var input = "";
var inputcommas = "";
var separator = ",";

function add(id, key, value) {
    var div = document.createElement("div");
    var remove_id = key.replace(/\s/g, "-");
    div.setAttribute("id", remove_id);
    //name="'+ value +'"
    if (id == "details")
        var details =
            '<div class="col-md-6"><div class="form-group row"><div class="col-md-10"><input placeholder="' +
            key +
            '" value="' +
            value +
            '" class="form-control col-md-10"  autocomplete ';
    else
        var details =
            '<div class="col-md-6"><div class="form-group row"><div class="col-md-10"><input placeholder="' +
            key +
            '" value="' +
            value +
            '" class="form-control col-md-10"  autocomplete ';
    key = key.toUpperCase().trim();
    if (key.indexOf("DATE") !== -1)
        details +=
            'type="date"></div><div class="col-md-2"><button onclick="addRemove(\'' +
            remove_id +
            '\')" style="border-radius: 100%; font-size: 12px;" class="btn-danger">X</button></div></div></div>';
    else if (key.indexOf("EMAIL") !== -1)
        details +=
            'type="email"></div><div class="col-md-2"><button onclick="addRemove(\'' +
            remove_id +
            '\')" style="border-radius: 100%;  font-size: 12px;" class="btn-danger">X</button></div></div></div>';
    else if (key.indexOf("ADDRESS") !== -1)
        details =
            '<div class="col-md-12"><div class="form-group"><textarea autocomplete placeholder="' +
            key +
            '" class="form-control">' +
            value +
            '</textarea><div class="col-md-2"><button onclick="addRemove(\'' +
            remove_id +
            '\')" style="border-radius: 100%;  font-size: 12px;" class="btn-danger">X</button></div></div></div>';
    else
        details +=
            'type="text"></div><div class="col-md-2"><button onclick="addRemove(\'' +
            remove_id +
            '\')" style="border-radius: 100%;  font-size: 12px;" class="btn-danger">X</button></div></div></div>';
    div.innerHTML = details;
    document.getElementById(id).appendChild(div);
}

function addRemove(id) {
    var remove_id = "#" + id;
    $(remove_id).remove();
    if (!isNaN(Number(id))) {
        alert(Number(id));
        $("#removed_tasks").append(
            '<input class="removed_add" type="hidden" value="' +
                Number(id) +
                '"  />'
        );
    }
}

function remove(id) {
    document
        .getElementById(id)
        .removeChild(document.getElementById(id).lastChild);
}

function parses(id) {
    var string = "{";
    var info = new Map();
    traverse(document.getElementById(id), info);
    info.forEach(function (value, key) {
        string += '"' + key + '" : ' + '"' + value + '", ';
        console.log(string);
    });

    // document.getElementById(id).childNodes.forEach(function(node, index, listObj) {
    //     var key = "";
    //     var nodeProp = node.firstChild.firstChild.lastChild;
    //     if(nodeProp.placeholder != null)
    //         key = nodeProp.placeholder.trim();
    //     else
    //         key = nodeProp.value.trim();
    //
    //         var value = nodeProp.value.trim();
    //         string += '"' + key + '" : ' + '"'+ value + '", ';
    //         console.log(string);
    //     },
    //     'myThisArg'
    // );

    if (string.indexOf(",") !== -1) {
        string = string.substring(0, string.lastIndexOf(",")) + "}";
        document.getElementById(id.substring(0, id.length - 1)).value = string;
    } else {
        document.getElementById(id.substring(0, id.length - 1)).value = "";
    }

    // console.log(string);
}
function traverse(node, data) {
    console.log(data);
    node.childNodes.forEach(function (node, index, listObj) {
        var name = "";
        var value = "";
        if (
            node instanceof HTMLInputElement ||
            node instanceof HTMLTextAreaElement
        ) {
            if (node.name.trim().length != 0) name = node.name.trim();
            else if (node.placeholder.trim().length != 0)
                name = node.placeholder.trim();
            else name = node.value.trim();
            value = node.value.trim();
            data.set(name, value);
            // console.log(name + ":" + value);
        } else if (node instanceof HTMLSelectElement) {
            if (node.name.trim().length != 0) name = node.name.trim();
            else if (node.placeholder.trim().length != 0)
                name = node.placeholder.trim();
            else name = node.options[node.selectedIndex].value;
            value = node.options[node.selectedIndex].value;
            data.set(name, value);
            // console.log(name + ":" + value);
        }

        if (node.hasChildNodes()) traverse(node, data);
        else return data;
    }, "arg");
}

function populate(map, id, data) {
    clear(id + "s");
    map.forEach(function (value, key) {
        if (document.getElementsByName(key)[0].id == id) {
            var details = JSON.parse(data[key]);
            Object.keys(details).forEach(function (key) {
                add(id + "s", key, details[key]);
            });
        } else {
            // console.log();
            // alert(data[key]);
            document.getElementsByName(key)[0].value = data[key];
        }
    });
}

function reversePopulate(map, id, pop) {
    clear(pop + "s");
    map.forEach(function (value, key) {
        if (key != "_token") {
            if (document.getElementsByName(key)[0] instanceof HTMLSelectElement)
                document.getElementsByName(key)[0].selectedIndex = 0;
            else if (
                document.getElementsByName(key)[0] instanceof
                    HTMLInputElement ||
                document.getElementsByName(key)[0] instanceof
                    HTMLTextAreaElement
            )
                document.getElementsByName(key)[0].value = "";
        }
    });
}

function clear(id) {
    document.getElementById(id).innerHTML = "";
}

function edit(id, data, action) {
    console.log(data);
    $("#" + id).trigger("reset");
    $("#tasks").html("");
    var info = new Map();

    traverse(document.getElementById(id), info);

    populate(info, "detail", data);
    if (action != "action") {
        action.forEach(function (value, key) {
            add("tasks", "" + value.task_id, value.task_name);
        });
    }
}

function delet(id, data, action) {
    edit(id, data, action);
}

function displayAdditonalInfo(id, element, value) {
    var details = element.options[element.selectedIndex].id;
    details = JSON.parse(details);
    // element.options[element.selectedIndex].value = details[value];
    details = JSON.parse(details[id + "s"]);
    clear(id + "s");
    Object.values(details).forEach(function (value) {
        add(id + "s", value, "");
    });
}

$("#addNewJob_to").on("click", function (e) {
    $("#task-form").trigger("reset");
    $("#job").trigger("reset");
    document.getElementById("tasks").innerHTML = "";
    document.getElementById("details").innerHTML = "";
    document.getElementById("addTask").style.display = "none";
    document.getElementById("addJob").style.display = "block";
    document.getElementById("save").style.display = "none";
});

/*
 * Update Jobs jobs, after any modifications has been done
 * in the form.
 */

$("#save").on("click", function (e) {
    parses("details");
    parses("tasks");
    parses("removed_tasks");
    $("#removed_tasks").html("");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "You want to update Jobs?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $("#loading_progress").modal("show");
            $.ajax({
                method: "post",
                data: $("#job").serialize(),
                url: "/admin-edit_jobs",
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    if (data.message === "success") {
                        $("#job_task_id").val(data.job_id);
                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf_token"]'
                                ).attr("content"),
                            },
                        });
                        $.ajax({
                            method: "POST",
                            dataType: "json",
                            url: "/sendNotification",
                            data: {
                                message:
                                    "Job" +
                                    data.data.job_name +
                                    "has been edited",
                                subject: "Job Edited",
                                check: "position",
                                condition: "<>",
                                reciever: "1",
                            },
                            success: function (data) {
                                console.log("success");
                            },
                            error: function (data) {
                                console.log("error");
                            },
                        });
                        $.ajax({
                            method: "post",
                            data: $("#task-form").serialize(),
                            url: "/admin-add_tasks",
                            success: function (data) {
                                swal({
                                    title: "success",
                                    text: "Update added Successfully",
                                    icon: "success",
                                });
                                //console.log("Task added Successfully");
                                $("#task-form").trigger("reset");
                                $("#job").trigger("reset");
                                $("#con-close-modal").modal("hide");
                            },
                            error: function () {
                                console.log("error");
                                // swal("error");
                            },
                        });
                    }
                },
                error: function () {
                    // swal("error");
                    console.log("error");
                },
            });
        } else {
            $("#loading_progress").modal("hide");
            swal("Jobs Not Updated");
        }
    });
});

/*
 *   End of editing jobs button script
 */

$("#addJob").on("click", function (e) {
    parses("details");
    parses("tasks");

    // console.log($('detail').val());

    swal({
        title: "FIRMUS JOBS",
        text: "About to add job",
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
                method: "post",
                data: $("#job").serialize(),
                url: "/admin-add_jobs",
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    $("#con-close-modal").modal("hide");
                    swal({
                        title: "Firmus Job Type",
                        text: "Job added Successfully",
                        icon: "success",
                    });
                    if (data.message === "success") {
                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf_token"]'
                                ).attr("content"),
                            },
                        });
                        $.ajax({
                            method: "POST",
                            dataType: "json",
                            url: "/sendNotification",
                            data: {
                                message:
                                    "Job" +
                                    data.data.job_name +
                                    "has been added",
                                subject: "Job Added",
                                check: "position",
                                condition: "<>",
                                reciever: "1",
                            },
                            success: function (data) {
                                //console.log('success');
                            },
                            error: function (data) {
                                $("#loading_progress").modal("hide");
                                console.log(
                                    "Error sending notifaction for new added job"
                                );
                            },
                        });
                        $("#loading_progress").modal("show");
                        $("#job_task_id").val(data.job_id);
                        $.ajax({
                            method: "post",
                            data: $("#task-form").serialize(),
                            url: "/admin-add_tasks",
                            success: function (data) {
                                $("#loading_progress").modal("hide");
                                swal("Task added Successfully");
                                //console.log("Task added Successfully");
                                $("#task-form").trigger("reset");
                                $("#job").trigger("reset");
                                $("#con-close-modal").modal("hide");
                            },
                            error: function () {
                                console.log("Error in adding task to job");
                                // swal("error");
                            },
                        });
                    }
                },
                error: function () {
                    $("#loading_progress").modal("hide");
                    swal({
                        title: "FIRMUS JOBS",
                        text: "Check for consistency and try again",
                        icon: "warning",
                    });
                    // console.log("error");
                },
            });
        } else {
            $("#loading_progress").modal("hide");
            swal({
                title: "FIRMUS JOBS",
                text: "Job not created",
                icon: "success",
            });
        }
    });
});

$(".deleteJob").on("click", function (e) {
    data = JSON.parse($(this).val());
    delet("job", data, "action");

    swal({
        title: "Are you sure?",
        text: "Once a job is deleted, you will not be able to recover!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            e.preventDefault();

            $.ajax({
                method: "post",
                data: $("#job").serialize(),
                url: "/admin-delete_jobs",
                success: function (data) {
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                "content"
                            ),
                        },
                    });
                    $.ajax({
                        method: "POST",
                        dataType: "json",
                        url: "/sendNotification",
                        data: {
                            message:
                                "Job" + data.data.job_name + "has been deleted",
                            subject: "Job Deleted",
                            check: "position",
                            condition: "<>",
                            reciever: "1",
                        },
                        success: function (data) {
                            console.log("success");
                        },
                        error: function (data) {
                            console.log("error");
                        },
                    });
                    $("#Job" + data["job_id"]).remove();
                    swal("Client removed");
                },
                error: function () {
                    swal("error");
                    // console.log("error");
                },
            });
        } else {
            swal("Job Not deleted");
        }
    });
});

// .forEach(function (value) {
//     console.log(value);
//     if(value.text == document.getElementById('job_id_get').textContent ) {
//         value.parent.value = value.value;
//     }
// });

$("#submit_job_request").on("click", function (e) {
    e.preventDefault();
    const pathname = window.location.pathname;
    let url = "/manager-jobs/add";

    if (pathname.includes("/employee-jobs/employee")) {
        url = "/employee-jobs/add";
    }

    parses("details");
    var info = JSON.parse($("#jobsMenu").val());


    // document.getElementById('jobsMenu').options[document.getElementById('jobsMenu').selectedIndex].value = info.job_id;

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    swal({
        title: "Are you sure?",
        text: "By clicking Ok. You are sure everything is accurate",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $("#loading_progress").modal("show");
            $.ajax({
                method: "post",
                data: $("#job_request_form").serialize(),
                url: url,
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    swal({
                        title: "Firmus Job Request",
                        text: "Job Request Made Successfully",
                        icon: "success",
                    });

                    var job_request_information =
                        '<tr id="Job' +
                        data.Data_back.job_id +
                        ' " ><td>' +
                        data.Data_back.job_name +
                        "</td><td>" +
                        data.client_info.company_name +
                        "</td><td>" +
                        data.Data_back.status +
                        "</td><td>" +
                        data.Data_back.created_at +
                        "</td><td>" +
                        data.Data_back.created_at +
                        "</td></td>";

                    job_request_information +=
                        '<td><button class="btn btn-primary client_edit_info" value="  ' +
                        data.Data_back.client_id +
                        ' ">Edit</button> <button class="btn btn-danger client_delete_info" value=" ' +
                        data.Data_back.job_id +
                        '">Delete</button></td></tr>';

                    $("#job_request_tbody").append(job_request_information);

                    $("#job_request_form").trigger("reset");
                    $("#details").html("");
                    $("#con-close-modal").modal("hide");
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                "content"
                            ),
                        },
                    });
                    $.ajax({
                        method: "POST",
                        dataType: "json",
                        url: "/sendNotification",
                        data: {
                            message:
                                "Job Request" +
                                data.Data_back.reference_number +
                                "has been added",
                            subject: "Job Request",
                            check: "position",
                            condition: "=",
                            reciever: "Finance Officer",
                        },
                        success: function (data) {
                            console.log("success");
                        },
                        error: function (data) {
                            console.log("error");
                        },
                    });
                    window.location.reload();
                },
                error: function () {
                    $("#loading_progress").modal("hide");
                    swal("There was a problem making job request..");
                },
            });
        } else {
            document.getElementById("jobsMenu").options[
                document.getElementById("jobsMenu").selectedIndex
            ].value = JSON.stringify(info);
            swal("Request cancelled...");
        }
    });
});

$(".edit_job_request").on("click", function (e) {
    $("#jobsMenu").prop("disabled", true);
    //$('#client_detail').prop( "disabled", true );
});

$("#edit_job_request").on("click", function (e) {
    parses("details");

    // var info = JSON.parse();
    document.getElementById("jobsMenu").options[
        document.getElementById("jobsMenu").selectedIndex
    ].value = $("#jobsMenu").val();

    // let job_request_edit_url = "/manager-jobs_edit"; old
    let job_request_edit_url = "/manager-jobs/edit";

    if (location.pathname.includes('employee-jobs/employee')) {
        job_request_edit_url = '/employee-jobs/edit'
    }

    swal({
        title: "Update Job Request",
        text: "Update job request details",
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
                method: "post",
                data: $("#job_request_form").serialize(),
                url: job_request_edit_url,
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    swal({
                        title: "Firmus Job Request",
                        text: "Job Request Edited Successfully",
                        icon: "success",
                    });
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                "content"
                            ),
                        },
                    });
                    $.ajax({
                        method: "POST",
                        dataType: "json",
                        url: "/sendNotification",
                        data: {
                            message:
                                "Job Request" +
                                data.Data_back.reference_number +
                                "has been updated",
                            subject: "Job Request",
                            check: "position",
                            condition: "=",
                            reciever: "Finance Officer",
                        },
                        success: function (data) {
                            console.log("success");
                        },
                        error: function (data) {
                            console.log("error");
                        },
                    });
                    $("#job_request_form").trigger("reset");
                    $("#details").html = "";
                    $("#con-close-modal").modal("hide");
                },
                error: function () {
                    $("#loading_progress").modal("hide");
                    swal("error");
                    // console.log("error");
                },
            });
        } else {
            $("#loading_progress").modal("hide");
            swal({
                title: "job Request",
                text: "Job Request details not updated",
                icon: "warning",
            });
        }
    });
});

$("#datatable-buttons").on("click", ".deleteJobRequest", function (e) {
    data = JSON.parse($(this).val());

    delet("job_request_form", data, "action");
    swal({
        title: "Are you sure?",
        text: "Once a Job Request is deleted, you will not be able to recover!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $("#loading_progress").modal("show");

            e.preventDefault();

            $.ajax({
                method: "post",
                data: $("#job_request_form").serialize(),
                url: "/manager-jobs_delete",
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    $("#Job" + data).remove();
                    swal("Job Request Removed");
                    swal({
                        title: "Firmus Job Request",
                        text: "Job Request Deleted Successfully",
                        icon: "success",
                    });
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                "content"
                            ),
                        },
                    });
                    $.ajax({
                        method: "POST",
                        dataType: "json",
                        url: "/sendNotification",
                        data: {
                            message:
                                "Job Request" +
                                data.Data_back.reference_number +
                                "has been updated",
                            subject: "Job Request",
                            check: "position",
                            condition: "=",
                            reciever: "Manager",
                        },
                        success: function (data) {
                            console.log("success");
                        },
                        error: function (data) {
                            console.log("error");
                        },
                    });
                },
                error: function () {
                    swal("error");
                },
            });
        } else {
            swal("Job Request Not deleted");
        }
    });
});

$("#datatable-buttons").on("click", ".assignJobRequest", function (event) {

    var job_assign_id = $(this).val();
    
    // var job_assign_url = "/job_assign_retrieve_information/" + job_assign_id;
    var job_assign_url = "/manager-jobs/assign_retrieve_information/" + job_assign_id;

    if (location.pathname.includes('employee-jobs/employee'))
        job_assign_url  = "/employee-jobs/assign_retrieve_information/" + job_assign_id;

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    event.preventDefault();

    $.ajax({
        type: "GET",
        dataType: "json",
        url: job_assign_url,
        success: function (data) {
            $("#reference_num").val(data.data_inform.reference_number);
            $("#job_request_id_detail").val(data.data_inform.job_request_id);
            //$("#field-2").append("<option value = '" + data.data_in_job_name.job_name+ "'>" +  data.data_in_job_name.job_name + "</option>");
            $("#field-2").val(data.data_in_job_name);
            $("#field-3").val(data.data_in_client);
            $("#field-4").val(data.data_inform.created_at);
            var tr_info = "";
            $.each(data.employee_details, function (key, value) {
                tr_info +=
                    '<tr id="sime' +
                    key +
                    '" class="' +
                    data.job_assignment_details[key] +
                    '" ><td >' +
                    value +
                    "</td><td><button type='button' id=\"" +
                    key +
                    "\"  style=\"padding:0; width:28px; height:28px;\" class='emp_remove btn-rounded btn-danger pull-right '  onclick='emp_remove(" +
                    key +
                    ")'><i class='fa fa-minus-circle'></i></button></td></tr>";
            });
            $("#employeeList").html(tr_info);
        },
        error: function (e) {
            console.log(e)
        },
    });

    job_assign_id = "";
});

$("#add_job_gen").on("click", function (e) {
    $("#job_request_form").trigger("reset");
    $("#details").html("");
    var time = new Date();
    var generated_value = Math.random() * 90000;
    // var generated_value = Math.random() % 10000000;
    let yearnumber = time.getFullYear().toString().substring(2); //to solve appending the year to the reference number
    generated_value += time.getMilliseconds();
    generated_value = Math.floor(generated_value);
    $("#reference_number").val("FA" + yearnumber + generated_value);
    $("#jobsMenu").prop("disabled", false);
    $("#client_detail").prop("disabled", false);
    document.getElementById("submit_job_request").style.display = "block";
    document.getElementById("edit_job_request").style.display = "none";
});

$("#assignJobRequestSend").on("click", function (e) {
    // parses('details');
    var jsonData = "{";
    // $('#employeeList tr[class=""]')
    $('#employeeList tr[class=""]').each(function (i, v) {
        var string = $(this).attr("id");
        try {
            var id = string.substring(4, string.length);
        } catch (exception) {
            return;
        }
        emp_remove(id);
        jsonData += '"' + string + '" : ' + '"' + id + '", ';
    });

    var removed_employee = "{";
    var info;
    var emp_id;
    $(".job_assignment_id").each(function (i, v) {
        info = $(this).val();
        emp_id = $(this).attr("id");
        removed_employee += '"' + emp_id + '" : ' + '"' + info + '", ';
    });

    removed_employee =
        removed_employee.substring(0, removed_employee.lastIndexOf(",")) + "}";
    jsonData = jsonData.substring(0, jsonData.lastIndexOf(",")) + "}";

    $("#jsonData").val(jsonData);
    $("#removed_employees").val(removed_employee);
    // var job_req_id = $('#job_request_id_detail').val();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    e.preventDefault();
    // let assign_job_url = "/jobs_assign";
    let assign_job_url = "/manager-jobs/assign";

    if (location.pathname.includes('/employee-jobs/employee')) {
        assign_job_url = "/employee-jobs/assign";
    }


    $.ajax({
        type: "post",
        dataType: "json",
        data: $("#job_make_assign_form").serialize(),
        url: assign_job_url,
        success: function (data) {
            //swal({title : "Firmus Job Assignment", text : "Job Assigned Successfully", icon : 'success'});
            var ref_no = data.data.reference_number;
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
            });
            // var employees = JSON.parse(jsonData);
            var employees = jsonData;
            console.log("employees ", employees);
            $.each(employees, function (key, value) {
                $.ajax({
                    method: "POST",
                    dataType: "json",
                    url: "/notification/send",
                    data: {
                        message:
                            "Job request" + ref_no + "has been assigned to you",
                        subject: "Job Assignment",
                        check: "emp_id",
                        condition: "=",
                        reciever: value,
                    },
                    success: function (data) {
                        console.log("success");
                    },
                    error: function (data) {
                        console.log("error");
                    },
                });
            });
            var employees_removed = JSON.parse(removed_employee);
            $.each(employees_removed, function (key, value) {
                $.ajax({
                    method: "POST",
                    dataType: "json",
                    url: "/notification/send",
                    data: {
                        message:
                            "You have been unassigned from Job Request" +
                            ref_no,
                        subject: "Job Unassignment",
                        check: "emp_id",
                        condition: "=",
                        reciever: value,
                    },
                    success: function (data) {
                        console.log("success");
                    },
                    error: function (data) {
                        console.log("error");
                    },
                });
            });
            $("#job_make_assign_form").trigger("reset");

            $("#custom-width-modal").modal("hide");
        },
        error: function () {
            swal("error");
            // console.log("error");
        },
    });
});

function filldatalist(prefix) {
    if (input.val().indexOf(separator) > -1 && options.length > 0) {
        datalist.empty();
        for (i = 0; i < optionsarray.length; i++) {
            if (prefix.indexOf(optionsarray[i]) < 0) {
                datalist.append(
                    '<option value="' + prefix + optionsarray[i] + '">'
                );
            }
        }
    }
}

//
//
//
// var eDatalist;

$(".progress_button").on("click", function () {
    JSON.parse($("#job_request_contact_information").val()).forEach(function (
        value,
        key
    ) {
        $("#clientsEmail").append(
            "<option value=" +
                JSON.parse(value.details)["EMAIL"] +
                ">" +
                JSON.parse(value.details)["COMPANY NAME"] +
                "</option>"
        );
    });

    datalist = jQuery("datalist");
    options = jQuery("datalist option");
    optionsarray = jQuery.map(options, function (option) {
        return option.value;
    });
    input = jQuery("input[list]");
    inputcommas = (input.val().match(/,/g) || []).length;
    var details = JSON.parse($("#job_request_id").val());
    var tasks_details = JSON.parse($("#tasks_details").val());

    $("#assigned_employees").html("");
    details.forEach(function (value, key) {
        $("#assigned_employees").append(
            "<tr><td>" + value.first_name + " " + value.last_name + "</td></tr>"
        );
    });

    $("#stages").html("");
    var i = 0;
    var bool = false;
    tasks_details.forEach(function (value, key) {
        if ($("#current_task_form").val().trim() == value.task_name.trim()) {
            $("#stages").append(
                '<li class="task_info active" onmouseout="unshow()"  onmouseover="hover(this.id)" id=" ' +
                    _.capitalize(value.task_name) +
                    ' "> </li>'
            );
            bool = true;
        } else if (!bool) {
            $("#stages").append(
                '<li  class="task_info cc active" onmouseout="unshow()" onmouseover="hover(this.id)" id=" ' +
                    _.capitalize(value.task_name) +
                    ' ">' +
                    "</li>"
            );
        } else if (bool) {
            $("#stages").append(
                '<li  class="task_info" onmouseout="unshow()" onmouseover="hover(this.id)" id=" ' +
                    _.capitalize(value.task_name) +
                    ' ">' +
                    "</li>"
            );
        }

        i++;
    });

    var row_id = "#" + $(this).parent().parent().attr("id") + " td";
    $(row_id).each(function (i, v) {
        var nm = "[name='" + $(this).attr("id") + "']";
        $(nm).val($(this).text());
    });

    var job_assignment_id = $(this).parent().parent().attr("id");
    job_assignment_id = job_assignment_id.substring(
        3,
        job_assignment_id.length
    );

    $("#task_job_assignment_id").val(job_assignment_id);

    intervalMessage = setInterval(getMessages, 1000);
});

$("#alt_email").on("change paste keyup", function () {
    var inputtrim = input.val().replace(/^\s+|\s+$/g, "");
    var currentcommas = (input.val().match(/,/g) || []).length;
    console.log(currentcommas);
    if (inputtrim != input.val()) {
        console.log(currentcommas);

        if (inputcommas != currentcommas) {
            var lsIndex = inputtrim.lastIndexOf(separator);
            var str = lsIndex != -1 ? inputtrim.substr(0, lsIndex) + ", " : "";
            filldatalist(str);
            inputcommas = currentcommas;
        }
        input.val(inputtrim);
    }
});

$(".close_clear").click(function () {
    clearInterval(intervalMessage);
});

$("#sendTasksUpdate").click(function () {
    // $('#client_remark').val($('#current_task_form').val());
    $("#renewal_date_o").val($("#renewal_date_proxy").val());
    // $('#client_remark').val($('#current_task_form').val());

    if ($("#field-5").val() == " ") {
        $("#field-5").css("border", "1px solid red");
        return;
    } else if ($("#client_remarks").val() == "") {
        $("#client_remarks").css("border", "1px solid red");
        return;
    } else if ($("#alt_email").val() == "") {
        $("#alt_email").css("border", "1px solid red");
        return;
    }

    var client_email = $("#alt_email").val();

    if ($("#alt_email").val() == "") {
        client_email = "abcd@firmus.com";
    }

    swal({
        title: "Task Update",
        text: `Attempting updating status of this task\nAn email notification will be sent ${client_email}`,
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

            $.ajax({
                type: "POST",
                dataType: "json",
                data: $("#job_task_completion_send").serialize(),
                url: "/employee/save_job_task_completion",
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    swal({
                        title: "Task Update",
                        text: "Client Job updated successfully\nEmail updated initiated...",
                        icon: "success",
                    });
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                "content"
                            ),
                        },
                    });

                    $.ajax({
                        type: "post",
                        dataType: "json",
                        data: {
                            client_message: $("#client_remarks").val(),
                            alt_email: client_email,
                            reference_number: $("#field-1").val(),
                            client_name: $("#field-3").val(),
                            job_title: $("#field-2").val(),
                            subject: "FIRMUS JOB PROGRESS UPDATE",
                            choice: "Email_Job",
                        },
                        url: "/meeting/send_email_firmus",
                        success: function (data) {
                            swal({
                                title: "Nofitication",
                                text: "Automatic update sent to clients successfully",
                                icon: "success",
                            });
                            $("#custom-width-modal2").modal("hide");
                        },
                        error: function (e) {
                            console.log("Error sending message to client");
                            $("#custom-width-modal2").modal("hide");
                        },
                    });
                    $("#custom-width-modal2").modal("hide");
                    $("#job_task_completion_send").trigger("reset");
                    window.location.reload();
                },
                error: function () {
                    $("#loading_progress").modal("hide");
                    console.log("error");
                },
            });
        } else {
            swal({
                title: "Task Update",
                text: "Task not update",
                icon: "warning",
            });
        }
    });
});

function unshow() {
    $("#display_task").html(_.capitalize($("#current_task_form").val()));
}

function hover(id) {
    $("#display_task").html(id);
}

$("#enter_meeting").on("click", function (e) {
    var jsonData = "{";

    $("#employeeList tr").each(function (i, v) {
        var string = $(this).attr("id");
        // $('tr first:td button')
        var name_attendee = $(this).attr("name");
        var id = string.substring(5, string.length);
        emp_remove(id);

        jsonData += '"' + id + '" : ' + '"' + name_attendee + '", ';
    });

    jsonData = jsonData.substring(0, jsonData.lastIndexOf(",")) + "}";

    $("#jsonData").val(jsonData);

    swal({
        title: "Create Meeting",
        text: "Setting up meeting",
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
                data: $("#make_meetings").serialize(),
                url: "/make_meetings",
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    swal({
                        title: "Firmus Meeting",
                        text: "Meeting Created Successfully",
                        icon: "success",
                    });
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                "content"
                            ),
                        },
                    });

                    $.each(data.data, function (key, value) {
                        $.ajax({
                            method: "POST",
                            dataType: "json",
                            url: "/sendNotification",
                            data: {
                                message:
                                    "Meeting about" +
                                    data.meeting.purpose +
                                    " at" +
                                    data.meeting.date +
                                    " " +
                                    data.meeting.meeting_start_time +
                                    " in " +
                                    data.meeting.meeting_venue,
                                subject: "Meeting " + data.meeting.title,
                                check: "emp_id",
                                condition: "=",
                                reciever: value.emp_id,
                            },
                            success: function (data) {
                                console.log("success");
                            },
                            error: function (data) {
                                console.log("error");
                            },
                        });
                    });
                    $("#make_meetings").trigger("reset");
                    $("#custom-width-modal").modal("hide");
                },
                error: function () {
                    $("#loading_progress").modal("hide");
                    swal({
                        title: "Something Went Wrong",
                        text: "Check all fields to make sure the right values are in there ",
                        icon: "warning",
                    });
                },
            });
        } else {
            $("#loading_progress").modal("hide");
            swal("Meeting not cancelled");
        }
    });
});

function emp_remove(id) {
    var class_job_assingment_id = $("#sime" + id).attr("class");
    if (class_job_assingment_id !== "") {
        $("#removed_important").append(
            '<input id="' +
                id +
                '" class="job_assignment_id" type="hidden" value="' +
                class_job_assingment_id +
                '"  />'
        );
        // console.log('done');
    }

    $("#sime" + id).remove();
}

// function meeting_remove(id) {
//     $('#'+id).remove();
// }

$(".meeting_table").on("click", ".view_update_btn", function () {
    $("#con-close-modal").modal("show");
    var meeting_id = $(this).val();
    $("#invited_employees").html("");

    $.ajax({
        method: "GET",
        dataType: "json",
        url: "/meeting/get_information/" + meeting_id,
        success: function (data) {
            $("#meeting_back_id").val(data.m_b.meeting_id);
            $("#meeting_title_back").val(data.m_b.title);
            $("#meeting_purpose_back").val(data.m_b.purpose);
            $("#meeting_date_back").val(data.m_b.date);
            var td_on = "";
            $.each(data.m_b_p, function (i, v) {
                td_on +=
                    '<tr id="sime' +
                    v.meeting_attends_id +
                    '" class="remove_them_moimoi"><td>' +
                    v.attendant_name +
                    "</td><td>";
                td_on +=
                    '<button type="button" id="' +
                    v.meeting_attends_id +
                    '" style="padding:0; width:28px; height:28px;" class="emp_remove btn-rounded btn-danger pull-right"';
                td_on +=
                    'onclick="emp_remove(this.id)"><i class="fa fa-minus-circle"></i> </button></td></tr>';
            });
            $("#invited_employees").append(td_on);

            $("#meeting_time_back").val(data.m_b.meeting_start_time);
            $("#meeting_time_back_end").val(data.m_b.meeting_end_time);
            $("#meeting_venue_back").val(data.m_b.meeting_venue);
            $("#meeting_minute_to_go").val(data.m_b.minutes);
        },
        error: function () {
            console.log("error");
        },
    });
});

$("#update_btn_minutes").click(function () {
    var jsonData = "{";

    $('#invited_employees tr[class=""]').each(function (i, v) {
        var string = $(this).attr("id");
        var name_attendee = $(this).attr("name");
        try {
            var id = string.substring(5, string.length);
        } catch (exception) {
            return;
        }

        jsonData += '"' + id + '" : ' + '"' + name_attendee + '", ';
    });

    jsonData = jsonData.substring(0, jsonData.lastIndexOf(",")) + "}";

    $("#jsonData").val(jsonData);

    var removed_employee = "{";
    var info;
    var emp_id;
    $(".job_assignment_id").each(function (i, v) {
        info = $(this).val();
        emp_id = $(this).attr("id");
        removed_employee += '"' + emp_id + '" : ' + '"' + info + '", ';
    });

    removed_employee =
        removed_employee.substring(0, removed_employee.lastIndexOf(",")) + "}";

    $("#removed_employees").val(removed_employee);

    var old_employee = "{";

    $('#invited_employees tr[class="remove_them_moimoi"]').each(function (
        i,
        v
    ) {
        var string = $(this).attr("id");
        var name_attendee = $(this).attr("name");
        try {
            var id = string.substring(5, string.length);
        } catch (exception) {
            return;
        }

        old_employee += '"' + id + '" : ' + '"' + name_attendee + '", ';
    });

    old_employee =
        old_employee.substring(0, old_employee.lastIndexOf(",")) + "}";

    swal({
        title: "Adding Meeting Minutes",
        text: "Firmus meeting update",
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

            $.ajax({
                method: "POST",
                dataType: "json",
                data: {
                    minutes: $("#meeting_minute_to_go").val(),
                    title: $("#meeting_title_back").val(),
                    purpose: $("#meeting_purpose_back").val(),
                    meeting_status: $("#assignedEmployee_meeting_status").val(),
                    meeting_start_time: $("#meeting_time_back").val(),
                    meeting_end_time: $("#meeting_time_back_end").val(),
                    date: $("#meeting_date_back").val(),
                    meeting_venue: $("#meeting_venue_back").val(),
                    jsonData: $("#jsonData").val(),
                    removed_employees: $("#removed_employees").val(),
                },
                url: "/update_meeting_minutes/" + $("#meeting_back_id").val(),
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    swal({
                        title: "Firmus Meeting Updates",
                        text: "Meeting Updated Successfully",
                        icon: "success",
                    });
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                "content"
                            ),
                        },
                    });

                    if (jsonData !== "{") {
                        $.each(JSON.parse(jsonData), function (key, value) {
                            $.ajax({
                                method: "POST",
                                dataType: "json",
                                url: "/sendNotification",
                                data: {
                                    message:
                                        "Meeting about" +
                                        $("#meeting_purpose_back").val() +
                                        " at" +
                                        $("#meeting_date_back").val() +
                                        " " +
                                        $("#meeting_time_back").val() +
                                        " in " +
                                        $("#meeting_venue_back").val() +
                                        "has been postponed",
                                    subject:
                                        "Meeting " +
                                        $("#meeting_title_back").val() +
                                        "has been postponed",
                                    check: "emp_id",
                                    condition: "=",
                                    reciever: key,
                                },
                                success: function (data) {
                                    console.log("success");
                                },
                                error: function (data) {
                                    console.log("error");
                                },
                            });
                        });
                    }

                    if (old_employee !== "{") {
                        $.each(JSON.parse(old_employee), function (key, value) {
                            $.ajax({
                                method: "POST",
                                dataType: "json",
                                url: "/sendNotification",
                                data: {
                                    message:
                                        "Meeting about" +
                                        $("#meeting_purpose_back").val() +
                                        " at" +
                                        $("#meeting_date_back").val() +
                                        " " +
                                        $("#meeting_time_back").val() +
                                        " in " +
                                        $("#meeting_venue_back").val() +
                                        "has been updated",
                                    subject:
                                        "Meeting " +
                                        $("#meeting_title_back").val() +
                                        "has been updated",
                                    check: "emp_id",
                                    condition: "=",
                                    reciever: key,
                                },
                                success: function (data) {
                                    console.log("success");
                                },
                                error: function (data) {
                                    console.log("error");
                                },
                            });
                        });
                    }

                    if (removed_employees !== "{") {
                        $.each(
                            JSON.parse(removed_employees),
                            function (key, value) {
                                $.ajax({
                                    method: "POST",
                                    dataType: "json",
                                    url: "/sendNotification",
                                    data: {
                                        message:
                                            "You have been removed from the meeting about" +
                                            $("#meeting_purpose_back").val() +
                                            " at" +
                                            $("#meeting_date_back").val() +
                                            " " +
                                            $("#meeting_time_back").val() +
                                            " in " +
                                            $("#meeting_venue_back").val() +
                                            "has been updated",
                                        subject:
                                            "Meeting" +
                                            $("#meeting_title_back").val() +
                                            "has been updated",
                                        check: "emp_id",
                                        condition: "=",
                                        reciever: key,
                                    },
                                    success: function (data) {
                                        console.log("success");
                                    },
                                    error: function (data) {
                                        console.log("error");
                                    },
                                });
                            }
                        );
                    }

                    $("#update_btn_minutes").hide();
                    $("#editBtn").show();
                    $("#con-close-modal").modal("hide");
                    $("#minutes_forms").each(function () {
                        $(this).find(":input").prop("disabled", true);
                    });
                    $("#update_meeting_info").hide();
                    $("#summernote").html("");
                    $("#summernote").text("");
                },
                error: function () {
                    $("#loading_progress").modal("hide");
                    swal({
                        title: "Error with minutes",
                        text: "Something went wrong, Try Again",
                        icon: "warning",
                    });
                },
            });
        } else {
            $("#loading_progress").modal("hide");
            swal({
                title: "Meeting Minutes",
                text: "Minute not updated",
                icon: "success",
            });
        }
    });
});

$("#closeBtn").click(function () {
    $("#update_meeting_info").hide();
    $("#update_btn_minutes").hide();
    $("#editBtn").show();
    $("#summernote").summernote("destroy");
    $("#summernote").html("");
    $("#summernote").text("");
});

$("#editBtn").click(function () {
    try {
        $("#summernote").html($("#meeting_minute_to_go").val());
        $("#summernote").summernote({
            placeholder: "Edit minutes for meeting",
            tabsize: 2,
            height: 100,
            callbacks: {
                onKeyup: function (e) {
                    $("#meeting_minute_to_go").val($(".note-editable").html());
                },
            },
        });
    } catch (err) {
        $("#summernote").html("");
    }
});

$(".cancel_meeting").click(function (e) {
    swal({
        title: "Are you sure?",
        text: "You want to cancel this meeting!!!",
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
                url: "/update_meeting_status/" + $(this).val(),
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    swal({
                        title: "Firmus Meeting Updates",
                        text: "Meeting Cancelled",
                        icon: "success",
                    });
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                "content"
                            ),
                        },
                    });
                    $.each(data.data, function (key, value) {
                        $.ajax({
                            method: "POST",
                            dataType: "json",
                            url: "/sendNotification",
                            data: {
                                message:
                                    "Meeting about" +
                                    data.meeting.purpose +
                                    " at" +
                                    data.meeting.date +
                                    " " +
                                    data.meeting.meeting_start_time +
                                    " in " +
                                    data.meeting.meeting_venue +
                                    "has been cancelled",
                                subject:
                                    "Meeting " +
                                    data.meeting.title +
                                    "Cancelled",
                                check: "emp_id",
                                condition: "=",
                                reciever: value.emp_id,
                            },
                            success: function (data) {
                                console.log("success");
                            },
                            error: function (data) {
                                console.log("error");
                            },
                        });
                    });
                },
                error: function () {
                    console.log("error");
                },
            });
        } else {
            swal("Meeting not cancelled");
        }
    });
});

$("#updateBtn").click(function () {
    $("#FormAreaforhide").trigger("reset");
});

$("#datatable-buttons").on("click", ".makePayment", function (e) {
    displayNew();
    e.preventDefault();
    $("#" + $(this).val() + " td").each(function (i, v) {
        if ($(this).attr("id") == "payment_status") {
            if ($(this).text() == "PREFINANCED") {
                $("[name=status_of_payment]").hide();
                $("#status_of_payment_label").hide();
            }
        }
        $("[name=" + $(this).attr("id") + "]").val($(this).text());
    });
});

$("#pay_btn").on("click", function (e) {
    var amount_paid = parseFloat($("[name=amount_paid]").val());
    var amount_deficit = parseFloat($("[name=amount_deficit]").val());
    var been_payed = parseFloat($("[name=been_payed]").val());
    var job_cost = parseFloat($("[name=job_cost]").val());
    var payment_status = $("[name=status_of_payment]").val();

    swal({
        title: "Firmus Job Payment",
        text: "By Clicking Ok, you are sure everything is accurate",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            if (amount_paid > amount_deficit && payment_status != "REFUND") {
                swal({
                    title: "Firmus Job Payment",
                    text: "Check payment details, You Cannot OverPay",
                    icon: "warning",
                });
            } else if (amount_paid >= 0) {
                if (payment_status == "REFUND") {
                    $("[name=job_cost]").val(job_cost - amount_paid);
                    // $('[name=been_payed]').val(amount_paid + been_payed);
                    $("[name=amount_deficit]").val(
                        amount_deficit - amount_paid
                    );
                } else if (amount_paid <= amount_deficit) {
                    $("[name=been_payed]").val(amount_paid + been_payed);
                    $("[name=amount_deficit]").val(
                        amount_deficit - amount_paid
                    );
                } else {
                    setTimeout(function () {
                        $("#loading_progress").modal("hide");
                    }, 2000);
                    swal({
                        title: "Firmus Job Payment",
                        text: "Check payment details",
                        icon: "warning",
                    });
                    return;
                }
                $("#loading_progress").modal("show");
                $.ajax({
                    type: "post",
                    dataType: "json",
                    data: $("#make_payment_form").serialize(),
                    url: "/make_payment",

                    success: function (data) {
                        $("#loading_progress").modal("hide");
                        swal({
                            title: "Firmus Job Payment",
                            text: "Payment Successful",
                            icon: "success",
                        });
                        $("#make_payment_form").trigger("reset");
                        $("#con-close-modal").modal("hide");
                        console.log("Success");
                    },
                    error: function () {
                        // swal("error");
                        console.log("error");
                    },
                });
            } else {
                setTimeout(function () {
                    $("#loading_progress").modal("hide");
                }, 2000);
                swal({
                    title: "Firmus Job Payment",
                    text: "Check payment details",
                    icon: "warning",
                });
            }
        } else {
            $("#loading_progress").modal("hide");
            swal({
                title: "Firmus Job Payment",
                text: "Not Paid",
                icon: "warning",
            });
        }
    });
});

$("#datatable-buttons").on("click", ".viewTransactions", function (e) {
    var ref_no = $(this).val();
    //console.log(ref_no);

    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/viewTransactions/" + ref_no,
        success: function (data) {
            // console.log(data);
            $("#transactions_table").html(data);
        },
        error: function () {
            // swal('Hello');
            console.log("error");
        },
    });
});

$("#datatable-buttons").on("click", ".viewJob", function (e) {
    var job_id = $(this).val();
    console.log("job id ", job_id);

    let job_details_url = "/manager-jobs/details/" + job_id;

    if (location.pathname.includes("/employee-jobs/employee")) {
        job_details_url = "/employee-jobs/details/" + job_id;
    }

    console.log(job_details_url)

    // "/viewJobDetails/" + job_id

    $.ajax({
        type: "GET",
        dataType: "json",
        url: job_details_url,
        success: function (data) {
            $("#job_details_info").html(data);
            var tasks_details = JSON.parse($("#tasks_details").val());

            $("#stages").html("");
            var i = 0;
            var bool = false;
            tasks_details.forEach(function (value, key) {
                if (
                    $("#current_task_form").val().trim() ==
                    value.task_name.trim()
                ) {
                    $("#stages").append(
                        '<li class="task_info active" onmouseout="unshow()"  onmouseover="hover(this.id)" id=" ' +
                            _.capitalize(value.task_name) +
                            ' "> </li>'
                    );
                    bool = true;
                }
                if (!bool) {
                    $("#stages").append(
                        '<li  class="task_info cc active" onmouseout="unshow()" onmouseover="hover(this.id)" id=" ' +
                            _.capitalize(value.task_name) +
                            ' ">' +
                            "</li>"
                    );
                } else if (bool) {
                    $("#stages").append(
                        '<li  class="task_info" onmouseout="unshow()" onmouseover="hover(this.id)" id=" ' +
                            _.capitalize(value.task_name) +
                            ' ">' +
                            "</li>"
                    );
                }

                i++;
            });

            intervalMessage = setInterval(getMessages, 1000);
        },
        error: function () {
            // swal('Hello');
            console.log("error");
        },
    });
});

$("#post_message").on("click", function (e) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-Token": $('meta[name="csrf_token"]').attr("content"),
        },
    });

    e.preventDefault();

    $.ajax({
        method: "POST",
        dataType: "json",
        data: {
            job_request_id: $("#job_request_id_details").val(),
            message: $("#message").val(),
        },
        url: "/message",

        success: function (data) {
            getMessages();
            $("#message").val("");
        },
        error: function () {},
    });
});

$(".add_edit_btn").click(function () {
    console.log($(this).attr("id"));
});

$(".contactTable").on("click", ".view_contact", function (e) {
    $.ajax({
        method: "GET",
        url: "/address-book/view_firmus_contact/" + $(this).val(),
        success: function (data) {
            // console.log(data.website);
            $("#contact_name_det").val(data.contact_name);
            $("#contact_organization").val(data.organization);
            $("#contact_position").val(data.position);
            $("#contact_number").val(data.contact_number);
            $("#contact_address").val(data.address);
            $("#contact_email").val(data.email);
            $("#contact_website_det").val(data.website);
            $("#contact_date").val(data.created_at);
            $("#cont_remarks").val(data.contact_remarks);
        },
        error: function () {
            console.log("Error");
        },
    });
});

$(".view_contact_current").click(function (e) {
    $.ajax({
        method: "GET",
        url: "/address-book/view_firmus_contact/" + $(this).val(),
        success: function (data) {
            // console.log(data.website);
            $("#contact_name_det").val(data.contact_name);
            $("#contact_organization").val(data.organization);
            $("#contact_position").val(data.position);
            $("#contact_number").val(data.contact_number);
            $("#contact_address").val(data.address);
            $("#contact_email").val(data.email);
            $("#contact_website_det").val(data.website);
            $("#contact_date").val(data.created_at);
            $("#cont_remarks").val(data.contact_remarks);
        },
        error: function () {
            console.log("Error");
        },
    });
});

var contact_id;
$("#update_con").hide();

$(".contactTable").on("click", ".edit_cont_firm", function () {
    $(".update_con").show();
    $("#save_con").hide();

    $("#con-close-modal").modal("show");

    contact_id = $(this).val();

    $.ajax({
        method: "GET",
        url: "/address-book/view_firmus_contact/" + contact_id,
        success: function (data) {
            $("#contact_name").val(data.contact_name);
            $("#organization").val(data.organization);
            $("#position").val(data.position);
            $("#contact_number").val(data.contact_number);
            $("#address").val(data.address);
            $("#email").val(data.email);
            $("#Website").val(data.website);
            $("#contact_remarks").val(data.contact_remarks);
        },
        error: function () {
            console.log("Error");
        },
    });
});

function getMessages() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/getMessages/" + $("#job_request_id_details").val(),
        success: function (data) {
            $("#chat_messages").html(data);
        },
        error: function () {},
    });
}

$(".update_con").click(function () {
    swal({
        title: "Are you sure?",
        text: "You want to update this contact?",
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

            $.ajax({
                method: "POST",
                dataType: "json",
                data: $("#cont_forms").serialize(),
                url: "/update_firmus_contact_info/" + contact_id,
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    $("#cont_forms").trigger("reset");
                    $("#con-close-modal").modal("hide");
                    //$('#cont_info' + contact_id).replaceWith();
                    swal({
                        title: "Success",
                        text: "Successfully Updated",
                        icon: "success",
                    });
                    $.ajax({
                        method: "POST",
                        dataType: "json",
                        url: "/sendNotification",
                        data: {
                            message:
                                "Contact " +
                                data.data.contact_name +
                                "has been updated.",
                            subject: "Contact Updated",
                            check: "position",
                            condition: "<>",
                            reciever: "1",
                        },
                        success: function (data) {
                            console.log("success");
                        },
                        error: function (data) {
                            console.log("error");
                        },
                    });
                },
                error: function () {
                    console.log("Error");
                },
            });
        } else {
            swal("Contact not updated");
        }
    });
});

$(".close_cont").click(function () {
    $("#cont_forms").trigger("reset");
    $("#update_con").hide();
    $("#save_con").show();
});

$(".contactTable").on("click", ".del_cont_firm", function () {
    var del_id = $(this).val();
    swal({
        title: "Remove Contact?",
        text: "No one will see this contact if removed!!!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            //e.preventDefault();

            $.ajax({
                method: "POST",
                dataType: "json",
                url: "/delete_firmus_contact_info/" + del_id,
                success: function (data) {
                    $.ajax({
                        method: "POST",
                        dataType: "json",
                        url: "/sendNotification",
                        data: {
                            message:
                                "Contact " +
                                data.data.contact_name +
                                "has been deleted",
                            subject: "Contact Deleted",
                            check: "position",
                            condition: "<>",
                            reciever: "1",
                        },
                        success: function (data) {
                            console.log("success");
                        },
                        error: function (data) {
                            console.log("error");
                        },
                    });
                    $("#cont_info" + del_id).remove();
                    swal("Success");
                },
                error: function () {
                    console.log("Error");
                },
            });
        } else {
            swal("Contact not removed");
        }
    });
});

$("#loading").hide();

$("#sendMail").click(function () {
    if ($(".note-editable").text().length > 0) {
        if ($("#subject").val() == "") {
            alert("Sending a message with no subject");
        }
        $("#loading").show();
        $("#send_text").hide();

        var message = $(".note-editable").html();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/meeting/send_email_firmus",
            data: {
                contact_email: $("#contact_email").val(),
                client_message: message,
                employee_id: $("#emp_id").val(),
                choice: $("#choice").find(":selected").val(),
                subject: $("#subject").val(),
            },
            success: function (data) {
                $("#loading").hide();
                $("#send_text").show();
                $("#send_text").text(data.message);
                $(".note-editable").html("");
                $("#subject").val("");
            },
            error: function () {
                $("#loading").hide();
                $("#send_text").show();
                $("#send_text").text("Message Not Sent!!");
            },
        });
    } else {
        alert("cannot send blank email");
    }
});

$("#close_messages").click(function () {
    $("#hideArea1").show();
    $("#hideArea2").hide();
    $("#switchBtn").text("Send Message");
    $("#send_text").text("Send Message");
});

$(".add_firm_contact").click(function () {
    $("#con-close-modal").modal("show");
    $("#save_con").show();
    $(".update_con").hide();
});

$("#save_con").on("click", function () {
    swal({
        title: "Add Contact",
        text: "This contact will be visible to everyone in the organization",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $("#loading_progress").modal("show");

            $.ajax({
                method: "post",
                dataType: "json",
                url: "/send_contact",
                data: $("#cont_forms").serialize(),
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    $.ajax({
                        method: "POST",
                        dataType: "json",
                        url: "/sendNotification",
                        data: {
                            message: "Contact has been added",
                            subject: "Contact Added",
                            check: "position",
                            condition: "<>",
                            reciever: "1",
                        },
                        success: function (data) {
                            console.log("success");
                        },
                        error: function (data) {
                            console.log("error");
                        },
                    });

                    $("#cont_forms").trigger("reset");
                    $("#con-close-modal").modal("hide");
                    swal({
                        title: "Contact",
                        text: "Contact Added Successfully",
                        icon: "success",
                    });
                },
                error: function () {
                    swal({
                        title: "Error",
                        text: "Check required fields",
                        icon: "warning",
                    });
                },
            });
        } else {
            swal({
                title: "Contact",
                text: "Contact not added",
                icon: "warning",
            });
        }
    });
});

$(".save_changes").on("click", function () {
    swal({
        title: "Add Employee",
        text: "Adding new employee to the system",
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

            $.ajax({
                method: "post",
                dataType: "json",
                url: "/admin/employees-send-info",
                data: $("#employee_forms").serialize(),
                success: function (data) {
                    $("#loading_progress").modal("hide");
                    $("#cont_forms").trigger("reset");
                    $("#con-close-modal").modal("hide");
                    var login_details =
                        "USERNAME : " +
                        data.employe_log_details.username +
                        "\n";
                    login_details += "DEFAUL PASSWORD : 123456";
                    swal({
                        title: "LOGIN CREDENTIALS",
                        text: login_details,
                        icon: "success",
                    });
                },
                error: function () {
                    $("#loading_progress").modal("hide");
                    swal({
                        title: "Error",
                        text: "Check required fields",
                        icon: "warning",
                    });
                },
            });
        } else {
            swal({
                title: "Employee",
                text: "Employee not added",
                icon: "warning",
            });
        }
    });
});

function getNotification() {
    $.ajax({
        method: "GET",
        dataType: "json",
        url: "/notification/get",
        success: function (data) {
            // console.log(data);
            $("#messages_notifications").html(data);
        },
        error: function (data) {
            console.log("Error getting notification");
        },
    });
}

$(".clearAllMessages").on("click", function () {
    const size_of_children = $("#messages_notifications").children().length;

    if (size_of_children <= 0) {
        swal({
            title: "Message",
            text: "No notifications available to be deleted",
            icon: "warning",
        });
        return;
    }

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    swal({
        title: "Clear All Notifications",
        text: "Are you sure you want to clear all notifications?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "/deleteAllNotification",
                success: function (data) {
                    swal({
                        title: "Deletion Completed",
                        text: "All Notifications has been deleted",
                        icon: "success",
                    });
                    $(this).parent().parent().remove();
                },
                error: function (data) {
                    console.log("Error deleting notification");
                },
            });
        } else {
            swal({
                title: "Deletion Aborted",
                text: "Notification not delete",
                icon: "success",
            });
        }
    });
});

$("#messages_notifications").on("click", ".deleteNotification", function () {
    let a = $(this).data("notificationid");
    let notification_url = "/deleteNotificationEmployee/" + String(a).trim();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    swal({
        title: "Delete Notification",
        text: "Are you sure you want to delete this Notification?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                method: "POST",
                dataType: "json",
                url: notification_url,
                success: function (data) {
                    swal({
                        title: "Deletion Completed",
                        text: "Notification deleted",
                        icon: "success",
                    });
                    $(this).parent().remove();
                },
                error: function (data) {
                    console.log("Error deleting notification");
                },
            });
        } else {
            swal({
                title: "Deletion Aborted",
                text: "Notification not delete",
                icon: "success",
            });
        }
    });
    // alert(a);
    // swal(notification_url);
});

function countNotification() {
    $.ajax({
        method: "GET",
        dataType: "json",
        url: "/notification/count",
        // url : '/countNotification',
        success: function (data) {
            $("#countNotification").text(data.count);
            $("#countNotificationbadge").text(data.count);
        },
        error: function (data) {
            console.log("Error getting notification");
        },
    });
}

function getManagerStats() {
    $.ajax({
        method: "GET",
        dataType: "json",
        url: "/getManagerStats",
        success: function (data) {
            $("#jobStat").text(data.jobs);
            $("#employeeStat").text(data.employees);
            $("#clientStat").text(data.clients);
            $("#pendingJobStat").text(data.pending_jobs);
            $("#contactStat").text(data.contacts);
            $("#pendingPaymentStat").text(data.pending_payments);
        },
        error: function (data) {
            console.log("Error getting notification");
        },
    });
}

function getAdminStats() {
    $.ajax({
        method: "GET",
        dataType: "json",
        url: "/getAdminStats",
        success: function (data) {
            $("#employeeStat").text(data.employees);
            $("#activitiesStat").text(data.activities);
            $("#activitiesThisMonthStat").text(data.activities_this_month);
            $("#activitiesTodayStat").text(data.activities_today);
        },
        error: function (data) {
            console.log("Error getting notification");
        },
    });
}

function getFinanceStats() {
    $.ajax({
        method: "GET",
        dataType: "json",
        url: "/getFinanceStats",
        success: function (data) {
            $("#jobStat").text(data.jobs);
            $("#completePaymentStat").text(data.complete_payments);
            $("#totalPaymentStat").text(data.total_payments);
            $("#refundedPaymentStat").text(data.refunded_payments);
            $("#contactStat").text(data.contacts);
            $("#pendingPaymentStat").text(data.pending_payments);
        },
        error: function (data) {
            console.log("Error getting notification");
        },
    });
}

function getEmployeeStats() {
    $.ajax({
        method: "GET",
        dataType: "json",
        url: "/getEmployeeStats",
        success: function (data) {
            //console.log(data.assigned);
            $("#completedJobStat").text(data.completed_jobs);
            $("#unassingedJobStat").text(data.unassigned_jobs);
            $("#assignedJobStat").text(data.assigned_jobs);
            $("#pendingJobStat").text(data.pending_jobs);
            $("#contactStat").text(data.contacts);
            $("#activitiesStat").text(data.activities);
        },
        error: function (data) {
            console.log("Error getting notification");
        },
    });
}

setInterval(getNotification, 2000);
setInterval(countNotification, 2000);

function getStats() {
    //var winlocation = window.location;
    // winlocation.indexOf("finance-home");
    //console.log(window.location.pathname);

    if (
        window.location.pathname == "/finance-home" ||
        window.location.pathname == "/finance/home/partner-finance"
    ) {
        getFinanceStats();
    } else if (
        window.location.pathname == "/manager-home/manager" ||
        window.location.pathname == "/manager/home/partner"
    ) {
        getManagerStats();
    } else if (
        window.location.pathname == "/admin-home" ||
        window.location.pathname == "/admin/home/partner-admin"
    ) {
        getAdminStats();
    } else if (window.location.pathname == "/employee-home") {
        getEmployeeStats();
    }
}

setInterval(getStats, 2000);

$(".deleteNotification").on("click", function () {
    $.ajax({
        method: "POST",
        dataType: "json",
        url: "/deleteNotification/" + $(this).attr("id"),
        success: function (data) {
            console.log("success");
        },
        error: function (data) {
            console.log("Error deleting notification");
        },
    });
});

var timeoutCheck = null;
var t_value;

// if (
//     window.location.pathname != "track" ||
//     window.location.pathname != "tracked-result"
// ) {
//     t_value = setInterval(renewalNotification, 2000);
// }

if (timeoutCheck === "success") {
    clearInterval(t_value);
    console.log("Notification sent for renewal and ended");
}

function renewalNotification(){
  $.ajax({
    method: "GET",
    dataType:"JSON",
    url: "/address-book/sendReminder",
    success: function (data){
      timeoutCheck = data.success;
      console.log("getting Reminder Notification");
    },
    error: function(e){
      console.log("Error in getting REMINDER Notification");
    }
  });
}

let dt = $("#exampletable").DataTable();

// $("#generate_report").click(function () {
//     console.log("Reporting...")
//     let job_selected = $("#job_selection_box").val();
//     let job_name_selected = $("#job_selection_box").text();
//     let from_date = $("#from_date").val();
//     let to_date = $("#to_date").val();

//     if (job_selected == "SJ" || from_date == "" || to_date == "") {
//         $("#job_selection_box").css("border", "1px solid red");
//         $("#from_date").css("border", "1px solid red");
//         $("#to_date").css("border", "1px solid red");
//         swal({
//             title: "Error",
//             text: "Check Mandatory field",
//             icon: "warning",
//         });
//         return;
//     } else {
//         $("#job_selection_box").css("border", "1px solid #e3e3e3");
//         $("#from_date").css("border", "1px solid #e3e3e3");
//         $("#to_date").css("border", "1px solid #e3e3e3");
//     }

//     $.ajaxSetup({
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//         },
//     });

//     $.ajax({
//         method: "POST",
//         data: {
//             job_id: job_selected,
//             from_date: from_date,
//             to_date: to_date,
//         },
//         url: "/manager/generate_report",
//         success: function (data) {
//             let table_data = "";
//             let table_body = $("#report_table");
//             if (Object.keys(data.data).length == 0) {
//                 swal({
//                     title: "Query result",
//                     text: "No queries found",
//                     icon: "success",
//                 });
//             }

//             $.each(data.data, function (index, value) {
//                 table_body.html("");
//                 $("#total_output").text("");
            //     table_data += `<tr role="row">
            //   <td class="sorting_1" tabindex="0">${value.date_logged}</td>
            //   <td>${value.job_name}</td>
            //   <td>${value.company_name}</td>
            //     <td>${value.job_cost}</td>
            // </tr>`;
//                 table_body.append(table_data);
//             });
//             $("#total_output").text("Total amount (GHS): " + data.total);
//         },
//         error: function (error) {
//             console.log(error);
//         },
//     });

//     //alert(job_selected + " " + from_date + " " + to_date);
// });

function populateDataTable(data) {
    console.log("populating data table...");
    // clear the table before populating it with more data
    dt.clear();
    var length = Object.keys(data).length;
    console.log(length);
    $.each(data, function (index, value) {
        dt.row
            .add({
                a: "Hello",
                b: "Hello",
                c: "Hello",
                d: "Hello",
                Issued: "",
                Expiry: "",
                total: "",
            })
            .draw();
        // console.log(value.date_logged);
    });
    // for(var i = 1; i < length+1; i++) {
    //   var query = data[i];
    //  console.log(query);
    //   // You could also use an ajax property on the data table initialization
    //   $('#exampletable').dataTable().fnAddData( [
    //     data.date_logged,
    //     data.job_name,
    //     data.company_name,
    //     data.job_cost
    //   ]);
    // }
}

$("#editBtn").click(function () {
    if ($("#editBtn").text() == "Edit") {
        $("#profileform").each(function () {
            $(this).find(":input").prop("disabled", false);
        });
        $("#editBtn").text("Save changes");
    } else if ($("#editBtn").text() == "Save changes") {
        $("#profileUpdateForm").submit();
    }
});

function uploadPic() {
    $("#uploadProfilePic").submit();
}

$("#addMeetingButton").click(function () {
    $("#minutes_forms").trigger("reset");
});

function progress_view(job_request_id) {
    document.getElementById("job_request_id").value = document.getElementById(
        "job_request" + job_request_id
    ).textContent;
    document.getElementById("tasks_details").value = document.getElementById(
        "tasks" + job_request_id
    ).textContent;
    document.getElementById("current_task_form").value =
        document.getElementById("current_task" + job_request_id).textContent;
    document.getElementById("current_task_id").value = document.getElementById(
        "current_task_id" + job_request_id
    ).textContent;
    document.getElementById("display_task").innerHTML = document.getElementById(
        "current_task" + job_request_id
    ).textContent;
    document.getElementById("current_task_form_job_request_id").value =
        document.getElementById(
            "job_request_id_id" + job_request_id
        ).textContent;
    document.getElementById("company_email").value = document.getElementById(
        "company_email" + job_request_id
    ).textContent;
}
