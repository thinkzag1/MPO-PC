<?php
defined('C5_EXECUTE') or die("Access Denied.");
/*
  Magic Tabs by John Liddiard (aka JohntheFish)
  www.jlunderwater.co.uk
  This software is licensed under the terms described in the concrete5.org marketplace.
  Please find the add-on there for the latest license copy.

  Create a tabbed interface simply by inserting magic tabs blocks into the page
 */

/*
  A whole load of body stuff, common to any player template
 */

extract($controller->getSets());

if (Page::getCurrentPage()->isEditMode()) {
    ?>
    <div class="ccm-edit-mode-disabled-item">
        <div style="padding:8px 0px;"><?php echo t('Magic Tabs Auto Play - Disabled in Edit Mode'); ?></div>
    </div>
    <?php
} else {

    $jh = Core::make('helper/json');
    $json_play_options = addslashes($jh->encode($play_options));
    $json_pause_options = addslashes($jh->encode($pause_options));


    $ch = Core::make('helper/jl_magic_tabs_continuity');
    $diag_enabled = $ch->get_global_param('autoplay_diagnostics_enabled'); // default false
    ?>
    <script>
        !function(a){var o = "<?php echo $cycle_action; ?>", i = "<?php echo trim($cycle_target); ?>", t = parseInt("<?php echo $cycle_interval; ?>", 10), _ = parseInt("<?php echo $diag_enabled; ?>", 10), e = "#<?php echo $player_id; ?>"; if (CCM_EDIT_MODE || window.location.href.indexOf("/dashboard/") > 0)return void a(e).show(); var n = !1; n = "undefined" != typeof Modernizr?Modernizr.touch:"ontouchstart"in document.documentElement, a(document).ready(function(){if (JtF && JtF.magic_slice){var c = function(){_ && window.console && window.console.log && window.console.log(1 == arguments.length?arguments[0]:arguments)}; try{var s = a.parseJSON("<?php echo $json_play_options; ?>"), r = a.parseJSON("<?php echo $json_pause_options; ?>")} catch (l){return void c(l)}setTimeout(function(){c("magic tabs auto play - setting up"), c("play_options", s), c("pause_options", r); var _ = JtF.magic_slice.derive_best_target_set("", i, i); if (!(a(_).length < 1)){var l = JtF.magic_slice.extract_set_class_sel(_); c("magic tabs auto play - target set", l); var p = a(e).show(); a(p).hasClass("jl_magic_tabs_additional_controls") && a(".jl_magic_tabs_controls." + l).first().append(p); var u, d, m = function(){c("magic tabs auto play - do_play "), d = !0, a(p).addClass("jl_magic_tabs_playing"), j()}, b = function(){d || (c("magic tabs auto play - set_play_handlers " + s.join(",")), a.inArray("tab_unhover", s) >= 0 && a(".jl_magic_tabs_controls." + l + ' a[href^="#jl_magic_tabs_"]').one("mouseout.play_options", m), a.inArray("body_unhover", s) >= 0 && a(".jl_magic_tabs_divider." + l).one("mouseout.play_options", m), a.inArray("tab_change", s) >= 0 && a(".jl_magic_tabs_controls." + l + ' a[href^="#jl_magic_tabs_"]').one("click.play_options", function(o, i){i && i.initialise || i && i.click_from_code || a(".jl_magic_tabs_divider." + l).one("jl_magic_tabs_done.play_options", function(){m()})}), a.inArray("body_click", s) >= 0 && a(".jl_magic_tabs_divider." + l).one("click.play_options", m), n && a.inArray("body_touch", s) >= 0 && a(".jl_magic_tabs_divider." + l).one("touchstart.play_options", m))}, g = function(){c("magic tabs auto play - clear_play_handlers " + s.join(",")), a.inArray("tab_unhover", s) >= 0 && a(".jl_magic_tabs_controls." + l + ' a[href^="#jl_magic_tabs_"]').off("mouseout.play_options"), a.inArray("body_unhover", s) >= 0 && a(".jl_magic_tabs_divider." + l).off("mouseout.play_options"), a.inArray("tab_change", s) >= 0 && a(".jl_magic_tabs_controls." + l + ' a[href^="#jl_magic_tabs_"]').off("click.tab_change"), a.inArray("body_click", s) >= 0 && a(".jl_magic_tabs_divider." + l).off("click.pause_options"), n && a.inArray("body_touch", s) >= 0 && a(".jl_magic_tabs_divider." + l).off("touchstart.pause_options")}, y = function(){c("magic tabs auto play - do_pause "), d = !1, a(p).removeClass("jl_magic_tabs_playing"), clearTimeout(u), h(), b()}, f = function(){d && (c("magic tabs auto play - set_pause_handlers " + r.join(",")), a.inArray("tab_hover", r) >= 0 && a(".jl_magic_tabs_controls." + l + ' a[href^="#jl_magic_tabs_"]').one("mouseover.pause_options", y), a.inArray("body_hover", r) >= 0 && a(".jl_magic_tabs_divider." + l).one("mouseover.pause_options", y), a.inArray("body_click", r) >= 0 && a(".jl_magic_tabs_divider." + l).one("click.pause_options", y), n && a.inArray("body_touch", r) >= 0 && a(".jl_magic_tabs_divider." + l).one("touchstart.pause_options", y))}, h = function(){c("magic tabs auto play - clear_pause_handlers " + r.join(",")), a.inArray("tab_hover", r) >= 0 && a(".jl_magic_tabs_controls." + l + ' a[href^="#jl_magic_tabs_"]').off("mouseover.pause_options"), a.inArray("body_hover", r) >= 0 && a(".jl_magic_tabs_divider." + l).off("mouseover.pause_options"), a.inArray("body_click", r) >= 0 && a(".jl_magic_tabs_divider." + l).off("click.pause_options"), n && a.inArray("body_touch", r) >= 0 && a(".jl_magic_tabs_divider." + l).off("touchstart.pause_options")}, j = function(){c("wait_and_tab"), g(), f(), c("preparing timeout", l), clearTimeout(u), u = setTimeout(function(){clearTimeout(u); var t = !0; if (a(".jl_magic_tabs_controls." + l).is(":visible")){if (t = JtF.magic_slice.external_tab_navigation("", o, i, ""), c("running next tab_item"), t === !1)return void y()} else clearTimeout(u), h(), d && t !== !1?j():y(); a(".jl_magic_tabs_divider." + l).one("jl_magic_tabs_done.wait_and_tab", function(){c("done, re-schedule next", l), clearTimeout(u), h(), d && t !== !1?j():y()})}, t)}; a.inArray("load", s) >= 0?(c("magic tabs auto play - play_options - load"), m()):b(), a.inArray("tab_change", r) >= 0 && a(".jl_magic_tabs_controls." + l + ' a[href^="#jl_magic_tabs_"]').on("click.pause_options", function(a, o){o && o.initialise || o && o.click_from_code || y()}), a(p).find("li.jl_magic_tabs_play, li.jl_magic_tabs_play>a").on("click", function(a){a.preventDefault(), a.stopPropagation(), m()}), a(p).find("li.jl_magic_tabs_play, li.jl_magic_tabs_pause>a").on("click", function(a){a.preventDefault(), a.stopPropagation(), y()})}}, 60)}})}(jQuery);
    </script>
    <?php
}

