$(document).ready(function() {
    if (typeof $.fn.dataTable !== 'undefined') {
        $.fn.dataTable.ext.errMode = 'none';
    }

    $(document).ajaxError(function(event, jqxhr, settings, exception) {
        if (exception === 'Unauthorized') {
            bootbox.confirm("Your session has expired. Would you like to be redirected to the login page?", function(result) {
                if (result) {
                    window.location.href = 'https://admin.hagzz.com/admin/admin';
                }
            });
        }
    });
});

