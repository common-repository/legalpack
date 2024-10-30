jQuery(document).ready(function ($) {
    $(".legalpack-color-selector").wpColorPicker();
    $(".legalpack-options-select-combo select").each(function () {
        var t = jQuery(this);
        var id = t.attr("id");
        var custom = t.find(".legalpack-custom-value-" + id);
        var tf = jQuery("input[name='custom_" + id + "']");
        t.change(function () {
            if (custom.prop("selected")) {
                tf.show();
            } else {
                tf.hide();
            }
        });
        tf.change(function () {
            custom.val(tf.val());
        });
        t.trigger("change");
        tf.trigger("change");
    });
    $(".legalpack-options-select-tag").each(function () {
        var t = jQuery(this);
        var id = t.attr("id");
        var n = jQuery(".legalpack-options-new-tag[id='new-tag-" + id + "']");
        t.change(function () {
            if (parseInt(t.val()) == 0) {
                n.show();
            } else {
                n.hide();
            }
        });
    });
    $(".legalpack-option-dependent").each(function () {
        var t = jQuery(this);
        var p = t.parent().parent();
        var depType = t.attr("type");
        var depVal = t.attr("value");
        var s = jQuery("#" + t.attr("source"));
        if (depVal == "show") {
            p.hide();
            t.removeClass("legalpack-hidden");
        }
        s.change(function () {
            var show = depType == "show";
            if (s.val() != depVal) {
                show = !show;
            }
            if (show) {
                p.show();
                t.show();
            } else {
                p.hide();
            }
        });
        s.trigger("change");
    });

    function send_to_editor( html ) {
        var editor,
            hasTinymce = typeof tinymce !== 'undefined',
            hasQuicktags = typeof QTags !== 'undefined';

        if ( ! wpActiveEditor ) {
            if ( hasTinymce && tinymce.activeEditor ) {
                editor = tinymce.activeEditor;
                wpActiveEditor = editor.id;
            } else if ( ! hasQuicktags ) {
                return false;
            }
        } else if ( hasTinymce ) {
            editor = tinymce.get( wpActiveEditor );
        }

        if ( editor && ! editor.isHidden() ) {
            editor.execCommand( 'mceInsertContent', false, html );
        } else if ( hasQuicktags ) {
            QTags.insertContent( html );
        } else {
            document.getElementById( wpActiveEditor ).value += html;
        }
    };

    $(".legalpack-shortcodes-source a").each(function () {
        var t=jQuery(this);
        var id=t.attr("editor");
        var data=t.attr("data");
        t.click(function(){
            send_to_editor(data);
            //tinymce.get(id).execCommand('mceInsertContent', false, data);
        });
    });
});
