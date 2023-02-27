let sendLog = () => {
    jQuery.ajax({
        type: 'POST',
        url: "/wp-admin/admin-ajax.php",
        data: {
            action: 'send_access_log',
            data: var_access_log
        },
        success: function (res) {
            // get res
        }
    })
};

jQuery(document).ready(sendLog);
