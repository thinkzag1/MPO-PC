<?php
defined('C5_EXECUTE') or die("Access Denied.");
/*
  Magic Tabs by John Liddiard (aka JohntheFish)
  www.jlunderwater.co.uk
  This software is licensed under the terms described in the concrete5.org marketplace.
  Please find the add-on there for the latest license copy.

  Create a tabbed interface simply by inserting magic tabs blocks into the page
 */

extract($controller->getSets());
$sanitized_label = $controller->extreme_sanitize($jump_label);
?>
<script>
    !function (t) {
        CCM_EDIT_MODE || window.location.href.indexOf("/dashboard/") > 0 || t(document).ready(function () {
            var i = "#<?php echo $button_id; ?>", e = "<?php echo $jump_action; ?>", n = "<?php echo trim($jump_target); ?>", o = "<?php echo $sanitized_label; ?>";
            setTimeout(function () {
                JtF && JtF.magic_slice && t(i).on("click", function (t) {
                    t.preventDefault(), t.stopPropagation(), JtF.magic_slice.external_tab_navigation(this, e, n, o)
                })
            }, 50)
        })
    }(jQuery);
</script>

