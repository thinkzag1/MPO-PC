<?php

namespace Concrete\Package\JlMagicTabs\Block\JlMagicTabsEnd;

use Concrete\Core\Block\BlockController;

defined('C5_EXECUTE') or die("Access Denied.");

/*
  Magic Tabs by John Liddiard (aka JohntheFish)
  www.jlunderwater.co.uk
  This software is licensed under the terms described in the concrete5.org marketplace.
  Please find the add-on there for the latest license copy.

  Create a tabbed interface simply by inserting magic tabs blocks into the page
 */

class Controller extends BlockController
{

    protected $btTable = "btJlMagicTabsEnd";
    protected $btInterfaceWidth = "400";
    protected $btInterfaceHeight = "260";

    /*
      Removes all grid framework elements in view.
      http://www.concrete5.org/profile/messages/-/view_message/inbox/612935/
      http://www.concrete5.org/profile/messages/-/view_message/inbox/614147/
     */
    protected $btIgnorePageThemeGridFrameworkContainer = true;

    public function getBlockTypeDescription()
    {
        return t('End a set of magic tabs.');
    }

    public function getBlockTypeName()
    {
        return t('End Magic Tabs');
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

    /*
      Implemented as a callback to minimise impact on many existing templates.
     */
    public function get_nesting_level_option()
    {
        if (isset($this->level)) {
            $nesting_level = (int) $this->level;
        }
        if (empty($nesting_level)) {
            $nesting_level = 0;
        }
        return $nesting_level;
    }

    public function get_nesting_level_options()
    {
        return array(0 => t('Current Level'),
            10 => t('All levels')
        );
    }

    public function get_nesting_level_options_label()
    {
        $la = $this->get_nesting_level_options();
        $lo = $this->get_nesting_level_option();
        return $la[$lo];
    }

}
