/**
 * Assigned Jobs — fills the progress modal from the row's data-job attribute.
 *
 * Send (#sendTasksUpdate) and Post (#post_message) are NOT handled here: the form
 * keeps the original ids and field names, so your existing handlers work as before.
 * Wrapped in DOMContentLoaded so it works if the layout loads jQuery at the end of <body>.
 */
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    var $ = window.jQuery;
    var $stageLabel = $('#jm-stage-label');

    function defaultStageLabel(job) {
        if (job.current_task) {
            return 'Current task: ' + job.current_task.name;
        }
        return job.is_done ? 'All tasks completed' : 'No tasks defined for this job';
    }

    function stageLabel(stage) {
        if (stage.state === 'completed') {
            return stage.name + ' (completed)';
        }
        if (stage.state === 'current') {
            return stage.name + ' (current' + (stage.status ? ', ' + stage.status : '') + ')';
        }
        return stage.name + ' (pending)';
    }

    function renderStages(job) {
        var stages = job.stages || [];
        var fallback = defaultStageLabel(job);
        var $ul = $('#jm-stages').empty();

        $stageLabel.text(fallback);

        stages.forEach(function (stage) {
            $('<li>')
                // "active" is the class the theme's .progressbar styles as reached
                .addClass(stage.state === 'completed' ? 'active' : stage.state)
                .attr('title', stage.name)
                .css('width', (100 / stages.length) + '%')
                .on('mouseenter', function () { $stageLabel.text(stageLabel(stage)); })
                .on('mouseleave', function () { $stageLabel.text(fallback); })
                .appendTo($ul);
        });
    }

    function renderAssignees(assignees) {
        var $table = $('#jm-assignees').empty();

        if (!assignees || !assignees.length) {
            $table.append($('<tbody>').append(
                $('<tr>').append($('<td class="text-muted">').text('No employees assigned.'))
            ));
            return;
        }

        $table.append($('<thead>').append(
            $('<tr>').append($('<th>').text('Name'), $('<th>').text('Email'))
        ));

        var $body = $('<tbody>').appendTo($table);
        assignees.forEach(function (person) {
            $('<tr>')
                .append($('<td>').text(person.name || ''), $('<td>').text(person.email || ''))
                .appendTo($body);
        });
    }

    function renderEmailSuggestions(emails) {
        var $list = $('#clientsEmail').empty();
        (emails || []).forEach(function (email) {
            $('<option>').attr('value', email).appendTo($list);
        });
    }

    function fill(job) {
        // Read-only details
        $('#jm-reference').val(job.reference || '');
        $('#jm-job-name').val(job.job_name || '');
        $('#jm-client').val(job.client || '');
        $('#jm-assignment-status').val(job.assignment_status || '');
        $('#jm-assigned-on').val(job.assigned_on || '');
        $('#jm-applicant').val(job.applicant || '');
        $('#job_request_id, #job_request_id_details').val(job.id);

        renderStages(job);
        renderAssignees(job.assignees);
        renderEmailSuggestions(job.email_suggestions);

        // Fields the existing Send handler reads (original ids/names)
        $('#current_task_id').val(job.current_task ? job.current_task.id : '');
        $('#current_task_form').val(job.current_task ? job.current_task.name : '');
        $('#task_job_assignment_id').val(job.assignment_id);
        $('#current_task_form_job_request_id').val(job.id);
        $('#company_email').val(job.client_email || '');
        $('#renewal_date_proxy, #renewal_date_o').val(job.renewal_date || '');
        $('#renewal1').toggle(!!job.is_final_task);
    }

    // Delegated so it survives DataTables paging/sorting re-renders.
    $(document).on('click', '.js-open-progress', function () {
        var job = $(this).data('job'); // jQuery parses the JSON attribute
        if (!job || !job.current_task) {
            return;
        }
        fill(job);
        $('#job-modal').modal('show');
    });

    $('#job-modal').on('hidden.bs.modal', function () {
        $('#job_task_completion_send')[0].reset();
        $('#jm-stages').empty();
        $stageLabel.text('');
    });
});