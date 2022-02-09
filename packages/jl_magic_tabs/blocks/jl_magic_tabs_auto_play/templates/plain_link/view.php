<?php
defined('C5_EXECUTE') or die("Access Denied.");
/*
  Magic Tabs by John Liddiard (aka JohntheFish)
  www.jlunderwater.co.uk
  This software is licensed under the terms described in the concrete5.org marketplace.
  Please find the add-on there for the latest license copy.

  Create a tabbed interface simply by inserting magic tabs blocks into the page
 */

$player_id = $controller->get_block_identifier();

/*
  Play/pause buttons (optional, controlled by block template)

  If you don't want them, just leave them out of the template.

  If you don't want them placed on top of the tabs controls and instead placed in line where the
  auto-play block is located, remove the class jl_magic_tabs_additional_controls.

  The class jl_magic_tabs_autoplay_default should be changed to whatever class any custom
  template provides. The purpose is to facilitate different player stylings on different
  tab sets on the same page.

 */
if (!empty($play_label) || !empty($pause_label)) {
    ?>
    <ul id="<?php echo $player_id; ?>" class="jl_magic_tabs_autoplay_player jl_magic_tabs_autoplay_plain_link jl_magic_tabs_additional_controls">
        <li class="jl_magic_tabs_play"><a href="#"><?php echo $play_label; ?></a></li>
        <li class="jl_magic_tabs_pause"><a href="#"><?php echo $pause_label; ?></a></li>
    </ul>
    <?php
}
//========================================================================================================================
/*
  A whole load of body stuff, common to any template
 */
Loader::packageElement('jl_magic_tabs_autoplay_body', 'jl_magic_tabs', array('controller' => $this->controller,
    'player_id' => $player_id,
        )
);

