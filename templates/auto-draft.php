<?php
if ( ! defined('ABSPATH')) {
    exit;
}

include_once LEGALPACK_PLUGIN_DIR . 'includes/admin-form.php';
use legalpack\admin_form\Section;
use legalpack\Legalpack;

?>
<style>
    #poststuff {
        display: none;
    }
    #legal-page-create-selector ul li {
        display: inline-block;
        margin: 1em 1em 0 0!important;
        background: none;
    }
    #legal-page-create-selector ul li a {
        width: 300px;
        border-radius: 4px;
        text-decoration: none;
        display: block;
        padding: 20px;
        background: none;
    }
    #legal-page-create-selector ul li a:hover {
        background: #F9F9F9;
    }
    #legal-page-create-selector ul li span {
        display: block;
    }
    #legal-page-create-selector ul li .title {
        font-size: 1.3em;
        line-height: 1.6em;
        font-weight: 600;
    }
    #legal-page-create-selector ul li .count {
        font-size: 1.3em;
        line-height: 1.6em;
    }
    #legal-page-create-selector ul li .description {
        font-size: 1.2em;
        line-height: 1.5em;
        margin: 15px 0 0 0;
        font-style: normal;
        color: #666;
    }
    
    #legal-page-container {
        background: none;
        border-radius: 4px;
        padding: 20px;
        margin: 20px 0 0 0;
    }
    #legal-page-container h1 {
        font-weight: bold;
    }
    
    #legal-page-container {
        display: none;
    }
    #legal-page-save {
        display: none;
    }
    
    .legal-pages-form h1 {
        margin: 0 0 25px 0;
    }
    .legal-pages-form .promo {
        margin: 0 0 25px 0;
        display: block;
        float: right;
        width: 250px;
    }
    .legal-pages-form .promo p {
        font-size: 1.2em;
        line-height: 1.5em;
        margin: 0;
        padding: 15px 20px;
        background: #FFF;
        border-radius: 4px;
    }
    .legal-pages-form label {
        font-size: 1.1em;
    }
    .legal-pages-form .legal-pages-form-radio li {
        margin: 0 0 10px 0;
    }
    .legal-pages-form hr {
        margin: 25px 0;
    }
    .legal-pages-form .legal-pages-form-section {
        margin: 0 0 5px 0;
    }
    .legal-pages-form .legal-pages-form-section-header {
        line-height: 1.6em;
    }
</style>

<div id="legal-page-create-selector">
    <ul>
        <?php
        $js_out          = array();
        $js_hidden       = array();
        $js_dependencies = array();
        foreach (Legalpack::get_legal_pages() as $k => $v) {
            ?>
            <li class="postbox">
                <a href="javascript:void(0);" id="<?php echo $k; ?>">
                    <span class="title"><?php echo $v; ?></span>
                    <span class="count">(<?php echo $pages_by_type[$k]; ?>)</span>
                    <span class="description">Create this legal page for your website by answering a few questions.</span>
                </a>
            </li>
            <?php
            Section::init();
            $js_out[]              = '<script type="text/html" id="tmpl-' . $k . "\">\n" .
                                     Legalpack::template(LEGALPACK_LEGAL_PAGES_DIR . 'admin/' . $k, array(), true) .
                                     "\n</script>\n";
            $js_hidden[ $k ]       = Section::get_start_hidden();
            $js_dependencies[ $k ] = Section::get_dependencies();
        }
        ?>
        <li>
            <a href="javascript:void(0);" id="legal-page-custom">
                <span class="title"><?php _e('Custom legal page', LEGALPACK_SLUG); ?></span>
                <span class="description">Create a custom legal page for your website.</span>
            </a>
        </li>
    </ul>
</div>

<input type="hidden" name="legal_page" value=""/>

<div id="legal-page-container" class="postbox"></div>

<div id="legal-page-submit">
    <p class="submit"><input type="submit" name="save" id="legal-page-save" class="button button-primary" value="<?php echo _x('Create Legal Page', 'create_page', LEGALPACK_SLUG); ?>"  /></p>
</div>

<?php
foreach ($js_out as $js) {
    echo $js;
}
?>
<script type="text/javascript">
    const LEGAL_PAGES_START_HIDDEN = {<?php foreach ($js_hidden as $k => $v) {
        echo '"' . $k . '": "#' . esc_js(join(', #', $v)) . "\",\n";
    }?>};
    const LEGAL_PAGES_DEPENDENCIES = {<?php foreach ($js_dependencies as $k => $v) {
        echo '"' . $k . '": ' . json_encode($v) . ",\n";
    }?>};
    var legalPageDep;

    function updateDependencies() {
        for (var section in legalPageDep) {
            var s = jQuery("#" + section);
            var args = legalPageDep[section];
            var state;
            var c = jQuery("#" + args[0] + ":visible");
            if (c.length) {
                if (typeof(args[1]) == "boolean") {
                    state = c.prop("checked");
                } else {
                    state = c.val();
                }
            }
            var show = args[2] == "show";
            if (state !== args[1]) {
                show = !show;
            }
            if (show) {
                s.show();
            } else {
                s.hide();
            }
            updateSectionRequirements(section, show);
        }
    }

    function updateSectionRequirements(sectionId, visible) {
        jQuery("#" + sectionId + " input[type=radio]").prop("required", visible);
    }

    jQuery(document).ready(function ($) {
        var cs = $("#legal-page-create-selector");
        var pg = $('#legal-page-container');
        var ps = $('#legal-page-save');
        
        cs.show().find("a").each(function () {
            var t = $(this);
            var id = t.attr("id");
            if (id == "legal-page-custom") {
                return;
            }
            t.click(function () {
                cs.hide();
                
                // show legal-page-container
                pg.show();
                
                // show submit button
                ps.show();
                
                var container = $("#legal-page-container");
                container.html(wp.template(id)({}));
                container.show();
                $("#legal-page-submit").show();
                legalPageDep = LEGAL_PAGES_DEPENDENCIES[id];
                $(LEGAL_PAGES_START_HIDDEN[id]).hide();
                $("input[name='legal_page']").val(id);
                container.find("input[type=radio],input[type=checkbox]").click(updateDependencies);
                container.find("input[type=radio]:visible").prop("required", true);
                $("#legal-page-save").click(function (e) {
                    container.find("input[type=radio]").each(function () {
                        var t = $(this);
                        var v = t.val();
                        if (v == "yes") {
                            t.val("legal-page-radio-yes");
                        } else if (v == "no") {
                            t.val("legal-page-radio-no");
                        }
                    });
                });
            });
        });
        $("#legal-page-custom").click(function () {
            cs.hide();
            $("#legal-page-form").remove();
            $("#poststuff").show();
            try {
                document.post.title.focus();
            } catch (e) {
            }
        });
    });
</script>
