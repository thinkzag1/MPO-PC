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
  Used to manage communication and continuity within and
  between magic tabs blocks.
  This MUST be present for magic tabs to work.
  DO NOT mess with it !!
 */
$ch = Core::make('helper/jl_magic_tabs_continuity');
/*
  Note change to first parameter since pre-5.7 release of Magic Tabs
 */
$ch->update_continuity($this->block->getBlockAreaObject(), $controller->get_nesting_level_option(), $controller->get_tab_continuity());


/*
  Extract some settings from the ciontinuity helper
 */
$setname = $ch->get_setname();


/* ======================================================================================================================
  This is a proforma for the tabs. It is never actually shown, but is cloned and used to build the tab mechanism.

  This template uses core jQuery.UI styling for the tabs using theme roller. It is intended as an example for those
  wanting to create their own jQuery.UI themed tabs.

  ////////////////////////////////////////////////////////////////////////////////
  //
  // THIS TEMPLATE HAS BEEN BUILT TO DEMONSTRATE INTEGRATION OF
  // TAB CSS GENERATED WITH THE JQUERY UI THEME ROLLER
  //
  ////////////////////////////////////////////////////////////////////////////////

 */

if ($ch->show_proforma()) {
    ?>
    <div 	id="<?php echo $setname; ?>_proforma"
          class="jl_magic_tabs_proforma <?php echo $setname; ?> jl_magic_tabs_hot_sneaks ui-tabs ui-widget ui-widget-content ui-corner-all"
          style="display:none;"
          data-selected-class="ui-tabs-selected ui-state-active"
          >
        <ul id="<?php echo $setname; ?>_proforma_inner_container"
            class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
            <li id="<?php echo $setname; ?>_proforma_tab_element"
                class="ui-state-default ui-corner-top"></li>
        </ul>
        <div style="clear:both"></div>
    </div>
    <?php
    }

//========================================================================================================================

    Loader::packageElement('jl_magic_tabs_view_body', 'jl_magic_tabs', array('heading' => $heading, 'heading_id'  => $heading_id,
            'tip' => $tip,
            'controller' => $this->controller,
            ));
    