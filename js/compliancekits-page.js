jQuery(document).ready(function () {
    const LEGALPACK_NOTICE_TEMPLATE = '<div class="updated settings-error notice is-dismissible"><p><strong>NOTICE</strong></p></div>';
    var noticeArea=jQuery("#legalpack_notice");
    function setNotice(notice) {
        noticeArea.html(LEGALPACK_NOTICE_TEMPLATE.replace("NOTICE", notice));
    }
    jQuery(".legalpack-box-enable-button a.button").click(function () {
        var b = jQuery(this);
        b.attr("disabled", "disabled");
        var id=b.attr("id");
        var s=jQuery("#status_" + id);
        var doc=jQuery(document);
        parent.jQuery.post(parent.ajaxurl, {
                action: id,
                nonce: LEGALPACK_TOGGLE_NONCE,
            },
            function (response) {
                b.removeAttr("disabled");
                if ((typeof(response.status) == "undefined") ||
                    (response.status != "success")) {
                    if(typeof(response.message) != "undefined") {
                        setNotice(response.message);
                    } else {
                        setNotice("Error");
                    }
                } else {
                    b.text(response.button_text);
                    s.text(response.status_text);
                    setNotice(response.notice_text);
                }
                doc.trigger('wp-updates-notice-added');
            });
    });
});
