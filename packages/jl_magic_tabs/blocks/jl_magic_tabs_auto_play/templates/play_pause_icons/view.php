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

  Icons assigned as background images in the view.css
 */
?>
<ul id="<?php echo $player_id; ?>" class="jl_magic_tabs_autoplay_player jl_magic_tabs_autoplay_play_pause_icons jl_magic_tabs_additional_controls">
    <li class="jl_magic_tabs_play" title="<?php echo $play_label; ?>" ><a href="#" ></a></li>
    <li class="jl_magic_tabs_pause" title="<?php echo $pause_label; ?>" ><a href="#" ></a></li>
</ul>
<?php
//========================================================================================================================
/*
  A whole load of body stuff, common to any template
 */
Loader::packageElement('jl_magic_tabs_autoplay_body', 'jl_magic_tabs', array('controller' => $this->controller,
    'player_id' => $player_id,
        )
);

