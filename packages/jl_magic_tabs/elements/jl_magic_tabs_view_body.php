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

$ch = Core::make('helper/jl_magic_tabs_continuity');
$diag_enabled = $ch->get_global_param('diagnostics_enabled'); // default false

/*
 * For MD integration. most efficient to simply set, rather than any tests
 * whether MD is installed at this stage.
 */
$ch->set_param('heading', $heading);
$ch->set_global_param('heading-' . $ch->get_nesting_level(), $heading);

if ($tab_history && $tab_history != '2') {
    $ch->set_param('tab_history', 'on');
}

/*
 * Create a heading with data to pass through info to script.
 * Some duplication of info, but this puts it all
 * in the right place and keeps it consistent.
 */
$heading_levels = $ch->heading_levels();
$heading_tag = '<h' . $heading_levels[$ch->get_nesting_level()]; // start an opening <hX> tag
$heading_tag .= ' ';
$heading_tag .= $ch->id_attribute_text($heading_id);
$heading_tag .= ' ';
$heading_tag .= $ch->class_attribute_text($controller);
$heading_tag .= ' ';
$heading_tag .= $ch->data_attribute_text($controller);

/*
 *  optional tip
 */
if (!empty($tip)) {
    $heading_tag .= ' title="' . $tip . '"';
}
$heading_tag .= '>'; // end of opening <hX> tag
$heading_tag .= $heading;
if ($diag_enabled) {
    $heading_tag .= ' [';
    $heading_tag .= t('%s; %s (%s)', $ch->get_setname(), $controller->get_nesting_level_options_label(), $ch->get_nesting_level());
    $heading_tag .= ']';
}

$heading_tag .= '</h' . $heading_levels[$ch->get_nesting_level()] . '>'; // close </hX> tag


if ($ch->in_edit_or_admin()) {
    ?>
    <style>
        .magic_tabs_controls.ccm-edit-mode-disabled-item { 
            text-align:left;
            border-top-left-radius:30px;
            border-top-right-radius:30px;
            padding:0 20px;
        }
        .magic_tabs_controls.ccm-edit-mode-disabled-item h<?php echo $heading_levels[$ch->get_nesting_level()]; ?> {
            margin-top: 5px;
            margin-bottom: 5px;
        }
    </style>	
    <div class="magic_tabs_controls ccm-edit-mode-disabled-item">
        <?php
        echo $heading_tag;
        ?>
        <em><small>[<b>
                    <?php echo t('Magic Tabs. Level: %s. ', $controller->get_nesting_level_options_label()); ?>
                </b>
                <?php echo t('When published, the above heading will be a tab and blocks below will be the body of the tab. '); ?>
                ]</small></em>
    </div>
    <?php
} else {
    echo $heading_tag;
}


/*
 * Script to initialise tabs, only gets included once per page.
 */
if ($ch->include_script()) {

    $auto_show = $ch->get_global_param('auto_show');  // default true
    $url_tab = $ch->get_url_tab();

    /*
     * If diagnostics are enabled, add some style to wrap each group of tabbed content.
     * Makes it easy to see what has been wrapped at each level
     */
    if ($diag_enabled) {
        ?>
        <style>
            div.jl_magic_tabs_divider.jl_magic_tabs_level_0 {
                outline: 1px solid pink;
            }
            div.jl_magic_tabs_divider.jl_magic_tabs_level_1 {
                outline: 1px dashed blue;
            }
            div.jl_magic_tabs_divider.jl_magic_tabs_level_2 {
                outline: 1px dotted cyan;
            }
        </style>
        <?php
    }

    /*
     * Mobile device trasitions, can be disabled
     */
    $mobile_no_transitions = $ch->get_global_param('mobile_no_transitions'); // default false

    /*
     * Core grid wrapping can be preserved or removed.
     */
    $preserve_grid_box = $ch->get_global_param('preserve_grid_box'); // default true
    $wrap_with_grid_box = $ch->get_global_param('wrap_with_grid_box'); // default false


    /*
     * Global behaviour in accordion mode. If you change accordion_always_open, you
     * will need to develop appropriate custom templates with minor tweaks to accordion css.
     */
    $accordion_always_open = $ch->get_global_param('accordion_always_open'); // default false
    $accordion_default_open = $ch->get_global_param('accordion_default_open'); // default false

    /*
     * Control number of ancestor levels to climb
     */
    $max_ancestor_levels = $ch->get_global_param('max_ancestor_levels');

    /*
     * What grid classes need to be removed for best results
     */
    $grid_classes_to_remove = $ch->get_global_param('grid_classes_to_remove');
    if (is_array($grid_classes_to_remove)) {
        $grid_classes_to_remove = implode(' ', $grid_classes_to_remove);
    }
    $grid_classes_to_remove = trim(preg_replace("/[^\w\-\_]+/", ' ', $grid_classes_to_remove));
    ?>
    <script type="text/javascript">
!function(a){if(!CCM_EDIT_MODE){var c=(parseInt("<?php echo Page::getCurrentPage()->getCollectionID(); ?>",10),"<?php echo $url_tab; ?>"),d=parseInt("<?php echo $auto_show; ?>",10),e=parseInt("<?php echo $mobile_no_transitions; ?>",10),f=parseInt("<?php echo $accordion_default_open; ?>",10),g=parseInt("<?php echo $accordion_always_open; ?>",10),h=parseInt("<?php echo $max_ancestor_levels; ?>",10),i=parseInt("<?php echo $preserve_grid_box; ?>",10),j=parseInt("<?php echo $wrap_with_grid_box; ?>",10),k="<?php echo $grid_classes_to_remove; ?>",l=[".jl_magic_tabs_end",".jl_magic_tabs_end, .jl_magic_tabs_end_n1",".jl_magic_tabs_end, .jl_magic_tabs_end_n1, .jl_magic_tabs_end_n2"];if(k)var m=k.split(/\s+/),n="."+m.join(", .");var o=parseInt("<?php echo $diag_enabled; ?>",10);a(document).ready(function(){if("undefined"==typeof JtF||void 0===JtF.magic_slice)return void(window.console&&window.console.log&&window.console.log("JtF.magic_slice script missing"));var b=JtF.magic_slice;o&&b.set_options({debug_flag:!0}),a(".jl_magic_tabs_proforma").each(function(b,c){a(this).appendTo("body")});var m=0;a(".jl_magic_tabs[data-jl-mt-level]").each(function(b,c){var d=parseInt(a(this).attr("data-jl-mt-level"),10);m=Math.max(m,d),m=Math.min(m,2)}),b.debug("Max tab levels "+m),a(".ccm-block-styles, .ccm-custom-style-container").has(":header.jl_magic_tabs").each(function(b,c){a(this).replaceWith(a(this).find(":header.jl_magic_tabs"))}),a(".ccm-block-styles, .ccm-custom-style-container").has(".jl_magic_tabs_end").each(function(b,c){a(this).replaceWith(a(this).find(".jl_magic_tabs_end"))}),a(".ccm-block-styles, .ccm-custom-style-container").has(".jl_magic_tabs_end_n1").each(function(b,c){a(this).replaceWith(a(this).find(".jl_magic_tabs_end_n1"))}),a(".ccm-block-styles, .ccm-custom-style-container").has(".jl_magic_tabs_end_n2").each(function(b,c){a(this).replaceWith(a(this).find(".jl_magic_tabs_end_n2"))}),a(".jl_magic_tabs").addClass("jl_magic_tabs_origin");var t,q=[],r=[],s=[],u=!1;b.debug("***** Tab blocks *****",a(".jl_magic_tabs"));for(var v=0;v<=m;v++){b.debug("== Building tab level "+v+" =="),t="jl_magic_tabs_level_"+v;var w;a.fn.jl_magic_clone_box_wrapper&&(w=a(".jl_magic_tabs."+t).jl_magic_clone_box_wrapper()),i||!a.fn.jl_magic_replace_out_of_box?(b.debug("Preserving grid box by climbing out of it while leaving elements in place"),a(".jl_magic_tabs."+t).jl_magic_climb_out_of_box().addClass("jl_magic_tabs_divider "+t),a(l[v]).jl_magic_climb_out_of_box().addClass("jl_magic_tabs_end_n"+v)):(b.debug("Possibly breaking grid box by replacing wrapping elements with tabbed elements"),a(".jl_magic_tabs."+t).jl_magic_replace_out_of_box().addClass("jl_magic_tabs_divider "+t),a(l[v]).jl_magic_replace_out_of_box().addClass("jl_magic_tabs_end_n"+v)),q=[],r=[],a(".jl_magic_tabs_divider."+t).each(function(c,d){var e=a(this).here_or_offspring('[data-jl-mt-setname][data-jl-mt-level="'+v+'"]').attr("data-jl-mt-setname");b.debug("Dividers key "+e+" from "+b.element_info(this)),e&&!q[e]&&(q[e]=a(this).here_or_offspring("[id]").attr("id"),r.push(e))}),b.debug("areas and groups ",q,r),a.each(r,function(c,i){var m=a(".jl_magic_tabs_divider."+t).has("."+i+"."+t).add(a(".jl_magic_tabs_divider."+t).filter("."+i+"."+t)),o=a(m).here_or_offspring("[data-jl-mt-current-tab]").first().attr("data-jl-mt-current-tab");b.debug("initial_tab "+o);var p=a(m).here_or_offspring("[data-jl-mt-continuity]").first().attr("data-jl-mt-continuity");b.debug("tab_continuity "+p);var q=a(m).here_or_offspring("[data-jl-mt-history]").first().attr("data-jl-mt-history");b.debug("tab_history "+q),q&&2!=q&&(u=!0);var r=a(m).here_or_offspring("[data-jl-mt-responsive-threshold]").first().attr("data-jl-mt-responsive-threshold");if(b.debug("responsive_threshold "+r),JtF.hide_then_show){var x=parseInt(a(m).here_or_offspring("[data-jl-mt-transition-speed]").first().attr("data-jl-mt-transition-speed"),10);if(b.debug("transition_speed "+x),x){var y=a(m).here_or_offspring("[data-jl-mt-transition-type]").first().attr("data-jl-mt-transition-type");b.debug("transition_type "+y);var z=a(m).here_or_offspring("[data-jl-mt-transition-easing]").first().attr("data-jl-mt-transition-easing");b.debug("transition_easing "+z);var A=a(m).here_or_offspring("[data-jl-mt-transition-direction]").first().attr("data-jl-mt-transition-direction");b.debug("transition_direction "+A);var B=a(m).here_or_offspring("[data-jl-mt-transition-adapt-dir]").first().attr("data-jl-mt-transition-adapt-dir");b.debug("transition_adaptive_dir "+B);var C=z.replace(/Context/,"Out"),D=z.replace(/Context/,"In")}}var E=a(m).jl_magic_makeSections(".jl_magic_tabs_divider,  .jl_magic_tabs_controls, "+l[v],"jl_magic_tabs_divider "+i+" "+t),F=!1;if(r&&a(window).width()&&a(window).width()<=r){var G=b.make_accordionset_html(m,i,t);b.debug("Inserting below threshold"),b.debug(G),a(G).each(function(c,d){F=!0,b.debug(this),a("#"+this.group_id).before(this.tab_group_item)}),b.debug("Created tabset "+i+" as accordion")}else{var H=b.make_tabset_html(m,i,t);b.debug(H);"top"==a(m).here_or_offspring("[data-jl-mt-insert-location]").first().attr("data-jl-mt-insert-location")?a("."+i+"."+t).jl_magic_CommonAncestor(h).first().prepend(H):a("."+i+"."+t).first().before(H),b.debug("Created tabset "+i+" as tabs")}var J=a(".jl_magic_tabs_divider."+i).first().attr("id"),K=a(".jl_magic_tabs_divider."+i).add(".jl_magic_tabs_controls."+i);if(b.debug("First Tab ID "+J),j&&w&&w[J]){var L=w[J];b.debug("Applying overall wrapper "+L),a(K).wrapAll(L),a(K).closest(".jl_magic_tabs_overall_wrapper").addClass(i).append('<div style="clear:both"></div>')}n&&a(K).find(n).removeClass(k),d&&a(".jl_magic_tabs."+i+"."+t).parents(".ccm-block-styles:hidden, .ccm-custom-style-container:hidden, .magic-tabs-hide").show().removeClass("magic-tabs-hide"),a(".jl_magic_tabs."+i).trigger("jl_magic_tabs_ready",{tabset_key:i}),a(".jl_magic_tabs."+i).on("click","a",function(c,h){c.stopPropagation(),c.preventDefault();var j=a(this).attr("href"),k=h&&h.initialise,l=b.nice_fragment(j);b.debug("TAB CLICKED, magic_to_show "+l+". from href "+j+b.stringify(h));var m=a(".jl_magic_tabs_controls."+i).first().attr("data-selected-class"),n=a(".jl_magic_tabs_controls."+i).first().attr("data-body-selected-class"),o=b.get_all_selected_clases_selector(m),r=a(".jl_magic_tabs_controls."+i).find(o);b.debug("current_tab",r);var s=[];a(r).each(function(c,d){b.debug("Looking for magic_to_hide",this);var e=b.nice_fragment(a(this).find("a").first().attr("href"));e&&e.length>0&&s.push(e)});var t=s.join(",");b.debug("magic_to_hide",t);var u=a.inArray(l,s);if(-1!=u)if(F&&!g)b.debug("Special case, accordion hiding but nothing to show"),l=null;else if(b.debug("Optimisation, removing tab to show from hide list"),s.splice(u,1),t=s.join(","),b.debug("revised magic_to_hide",t),t.length<1)return b.debug("Fast exit, nothing to hide"),!1;k&&F&&!g&&!f&&l?(s.push(l),l=null,b.debug("Special case, accordion starting all closed")):(a(this).addClass(m),a(this).closest("."+i).find("*").has(this).addClass(m)),a(r).removeClass(m).trigger("blur");var v=!0;B&&(v=b.get_direction(s,l));var w=a(E).not(t);if(b.debug("cancelling transitions on",w),void 0===jQuery.fn.finish?a(w).stop(!0,!0).hide():a(w).finish().hide(),t.length<1&&(t=l),JtF.hide_then_show&&!k&&x&&y&&z&&A)JtF.hide_then_show(a(t),a(l),{pn_dir:v,action:y,easing_in:D,easing_out:C,speed:x,direction:A,enable_completion:!0,simplify_for_mobile:e});else{t&&t!==l&&a(t).hide(),l&&a(l).show();var G=!0}if(d&&a(l).find(".ccm-block-styles:hidden, .ccm-custom-style-container:hidden, .magic-tabs-hide").show().removeClass("magic-tabs-hide"),n&&a(l).addClass(n),!k&&p&&(l||t)&&b.rememberTab(i,l),l){if(b.debug("jl_magic_tabs_show event"+b.element_info(l)),q&&"undefined"!=typeof History&&(!h||h&&!0!==h.history_state)){var H=a('.jl_magic_tabs a[href="'+j+'"]').text(),I=l.replace(/^\#/,""),J=History.getCurrentIndex(),K=History.getState();K&&K.data&&K.data.tab&&K.data.tab==l?b.debug("History.pushState duplicate ("+J+") "+I):(b.debug("History.pushState to ("+J+") "+I),History.pushState({_index:J,tab:l},H,"?tab="+I))}else b.debug("Not saving history");a(l).trigger("jl_magic_tabs_show",{tab_to_show:l,tabset_key:i}),G?a(l).trigger("jl_magic_tabs_done",{tab_to_show:l,tabset_key:i}):a(l).one("jl_show_hide_complete",function(c){b.debug("jl_show_hide_complete event",this),a(l).trigger("jl_magic_tabs_done",{tab_to_show:l,tabset_key:i})})}return!1});o&&a("ul.jl_magic_tabs."+i).has("a[href="+o+"]").length>0?s.push(a(".jl_magic_tabs."+i).find('a[href="'+o+'"]')):s.push(a(".jl_magic_tabs."+i).find("a").first())})}a("div.jl_magic_tabs_proforma").remove(),a.each(s.reverse(),function(b,c){a(this).trigger("click",{initialise:!0,click_from_code:!0})}),c&&"on"==c&&window.location.hash&&(c=window.location.hash),c&&"on"==c&&b.getQueryParameter("tab")&&(c=b.getQueryParameter("tab")),c&&"on"!=c&&"off"!=c&&b.open_named_tab(c,"",{initialise:!0,click_from_code:!0}),c&&"off"!=c&&(a('a.jl_magic_tabs_link_to_tab:not(.jl_magic_tabs_link_event_enabled), a[href="#jl_magic_tabs_link_to_tab"]:not(.jl_magic_tabs_link_event_enabled)').on("click",function(a){return b.maybe_tab_link(this,a,{click_from_code:!0})}),a(".jl_magic_tabs_link_to_tab:not(.jl_magic_tabs_link_event_enabled)").on("click","a",function(a){return b.maybe_tab_link(this,a,{click_from_code:!0})}),a('.jl_magic_tabs_link_to_tab, a[href="#jl_magic_tabs_link_to_tab"]').addClass("jl_magic_tabs_link_event_enabled")),u&&"undefined"!=typeof History&&setTimeout(function(){a(window).on("statechange",function(){var a=History.getState(),c=History.getCurrentIndex(),d=a.data._index;if(a&&a.data&&a.data.tab&&!a.internal&&d!=c-1){var e=a.data.tab,f=a.title;b.debug("history statechange to ("+d+") "+e+" "+f),b.external_tab_navigation(this,"goto",b.fragify(e),f,{history_state:!0,click_from_code:!0})}})},50)})}}(jQuery);</script>
    <?php
}