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

  This template adapts the core tabs with rainbow coloring

 */

if ($ch->show_proforma()) {
    ?>
    <div 	id="<?php echo $setname; ?>_proforma"
          class="jl_magic_tabs_proforma <?php echo $setname; ?> ccm-ui jl_magic_tabs_continued_rainbow"
          style="display:none;"
          data-selected-class="active jl_magic_tabs_continued_rainbow_active"

          >
        <ul id="<?php echo $setname; ?>_proforma_inner_container"
            class="nav-tabs nav">
            <li id="<?php echo $setname; ?>_proforma_tab_element"></li>
        </ul>
        <div style="clear:both"></div>
    </div>
    <?php
}

//========================================================================================================================

Loader::packageElement('jl_magic_tabs_view_body', 'jl_magic_tabs', array('heading' => $heading,
    'heading_id' => $heading_id,
    'tip' => $tip,
    'controller' => $this->controller,
));
