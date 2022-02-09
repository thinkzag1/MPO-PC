<?php
defined('C5_EXECUTE') or die("Access Denied.");
/*
  Magic Tabs by John Liddiard (aka JohntheFish)
  www.jlunderwater.co.uk
  This software is licensed under the terms described in the concrete5.org marketplace.
  Please find the add-on there for the latest license copy.

  Create a tabbed interface simply by inserting magic tabs blocks into the page
 */

$button_id = $controller->get_block_identifier();
$href_target = $controller->hrefify($jump_target);
?>
<a href="<?php echo $href_target; ?>" class="jl_magic_tabs_jump" id="<?php echo $button_id; ?>" style="margin-right: 1em;"><?php echo $jump_label; ?></a>
<?php
//========================================================================================================================
/*
  A whole load of body stuff, common to any template
 */
Loader::packageElement('jl_magic_tabs_jump_body', 'jl_magic_tabs', array('controller' => $this->controller,
    'button_id' => $button_id,
        )
);

