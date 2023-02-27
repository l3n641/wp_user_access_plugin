let sendLog = () => {
    jQuery.post(
        "/wp-admin/admin-ajax.php",
        {
            data: var_access_log,
            action: "send_access_log"
        },
        function (data) {

        },
        "json"
    );
}

jQuery(document).ready(sendLog);
