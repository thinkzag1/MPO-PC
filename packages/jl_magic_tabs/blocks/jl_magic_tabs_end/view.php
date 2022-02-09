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
  END A SET OF MAGIC TABS. NO NEED FOR ALTERNATE TEMPLATES. JUST LEAVE THIS ALONE
 */
$ch = Core::make('helper/jl_magic_tabs_continuity');
$end_markers = array('jl_magic_tabs_end jl_magic_tabs_end_n1 jl_magic_tabs_end_n2',
    'jl_magic_tabs_end_n1 jl_magic_tabs_end_n2',
    'jl_magic_tabs_end_n2');

$nesting_level_option = $controller->get_nesting_level_option();
$nesting_level = $ch->translate_nesting_level_option($nesting_level_option);

$ch->endset($nesting_level);

$end_class = $end_markers[$nesting_level];
?>
<div class="<?php echo $end_class; ?>" style="clear:both">
    <?php
    if (Page::getCurrentPage()->isEditMode()) {
        echo '<div class="ccm-edit-mode-disabled-item">';
        echo '<div style="padding:8px 0px;">' . t('Magic Tabs End %s - Marker for Edit Mode', $controller->get_nesting_level_options_label()) . '</div>';
        echo '</div>';
    }
    ?>
</div>

