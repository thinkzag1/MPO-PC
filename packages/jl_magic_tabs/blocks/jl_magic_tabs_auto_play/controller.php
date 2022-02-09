<?php

namespace Concrete\Package\JlMagicTabs\Block\JlMagicTabsAutoPlay;

use Concrete\Core\Block\BlockController;
use BlockType;
use Concrete\Package\JlMagicTabs\Block\JlMagicTabsJump\Controller as JlMagicTabsJumpController;

defined('C5_EXECUTE') or die("Access Denied.");

/*
  Magic Tabs by John Liddiard (aka JohntheFish)
  www.jlunderwater.co.uk
  This software is licensed under the terms described in the concrete5.org marketplace.
  Please find the add-on there for the latest license copy.

  Create a tabbed interface simply by inserting magic tabs blocks into the page
 */

/*
  Notes
  https://phab.krasnow.me/P1
  http://www.mesuva.com.au/blog/concrete5/adding-a-lightbox-to-the-image-block-in-concrete57-using-a-custom-block-template/
 */

if (is_object(BlockType::getByHandle('jl_magic_tabs_jump'))) {

    abstract class JlMtIntermediary extends JlMagicTabsJumpController
    {
        public function inheritance_complete()
        {
            return true;
        }

    }

} else {

    abstract class JlMtIntermediary extends BlockController
    {
        public function inheritance_complete()
        {
            return false;
        }

    }

}

class Controller extends JlMtIntermediary
{

    protected $btTable = "btJlMagicTabsAutoPlay";
    protected $btInterfaceWidth = "650";
    protected $btInterfaceHeight = "450";


    /*
      Removes all grid framework elements in view.
      http://www.concrete5.org/profile/messages/-/view_message/inbox/612935/
      http://www.concrete5.org/profile/messages/-/view_message/inbox/614147/
     */
    protected $btIgnorePageThemeGridFrameworkContainer = true;

    /*
      Cache settings inherited
     */
    public function getBlockTypeDescription()
    {
        return t('Automatically cycle through a set of magic tabs.');
    }

    public function getBlockTypeName()
    {
        return t('Auto Play Magic Tabs');
    }

    /*
      Unfortunately providing help causes 5.7.4 RC1 to puke, so it
      is commented out until the core is fixed
      public function getBlockTypeHelp() {
      return $this->getBlockTypeDescription();
      }
     */

    /*
      The set 'magic_tabs' has been added by the package controller
     */
    public function getBlockTypeDefaultSet()
    {
        return 'magic_tabs';
    }

    public function save($data)
    {
        if (is_array($data['play_options']) && count($data['play_options'])) {
            $data['play_options'] = implode(",", $data['play_options']);
        } else {
            $data['play_options'] = "";
        }
        if (is_array($data['pause_options']) && count($data['pause_options'])) {
            $data['pause_options'] = implode(",", $data['pause_options']);
        } else {
            $data['pause_options'] = "";
        }
        if (empty($data['cycle_interval'])) {
            $data['cycle_interval'] = 1000;
        }
        parent::save($data);
    }

    public function add()
    {
        $this->unpack_options();
        $this->set('play_label', t('Play'));
        $this->set('pause_label', t('Pause'));
    }

    public function edit()
    {
        $this->unpack_options();
    }

    public function view()
    {
        $this->unpack_options();
    }

    public function unpack_options()
    {
        $this->set('play_options', explode(',', $this->play_options));
        $this->set('pause_options', explode(',', $this->pause_options));
    }

    public function get_play_options_list()
    {
        return array(
            'load' => 'Start playing when loaded',
            'tab_unhover' => 'When the mouse moves off a tab control',
            'body_unhover' => 'When the mouse moves off a tab body',
            'tab_change' => 'When a tab is changed by ckicking it',
            'body_click' => 'When a tab body is clicked',
            'body_touch' => 'When a tab body is touched (touch devices only)',
        );
    }

    public function get_pause_options_list()
    {
        return array(
            'tab_hover' => 'When the mouse moves over a tab control',
            'body_hover' => 'When the mouse moves over a tab body',
            'tab_change' => 'When a tab is changed by ckicking it',
            'body_click' => 'When a tab body is clicked',
            'body_touch' => 'When a tab body is touched (touch devices only)',
        );
    }

}
