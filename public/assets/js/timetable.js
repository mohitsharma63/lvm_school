
$(document).ready(function() {
    // Initialize DataTables
    $('.datatable-button-html5-columns').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        columnDefs: [
            {
                targets: -1, // Last column (Actions)
                orderable: false,
                searchable: false
            }
        ],
        order: [[0, 'asc']],
        pageLength: 25,
        responsive: true
    });

    // Handle tab switching
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    });

    // AJAX form submission for creating timetables
    $('.ajax-store').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function(response) {
                if(response.ok) {
                    flash({
                        msg: 'Timetable created successfully!',
                        type: 'success'
                    });
                    form[0].reset();
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMsg = 'Validation failed: ';
                $.each(errors, function(key, value) {
                    errorMsg += value[0] + ' ';
                });
                flash({
                    msg: errorMsg,
                    type: 'danger'
                });
            }
        });
    });
});

// Delete confirmation function
function confirmDelete(id) {
    if(confirm('Are you sure you want to delete this timetable? This action cannot be undone.')) {
        $('#item-delete-' + id).submit();
    }
}

// Flash message function
function flash(options) {
    var message = options.msg || 'Message';
    var type = options.type || 'info';

    var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                    message +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    '</div>';

    // Remove existing alerts
    $('.alert').remove();

    // Add new alert at the top of the card body
    $('.card-body').prepend(alertHtml);

    // Auto hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}
