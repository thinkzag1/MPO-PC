<?php

namespace Concrete\Package\JlMagicTabs\Block\JlMagicTabsJump;

use Concrete\Core\Block\BlockController;
use Core;

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

    protected $btTable = "btJlMagicTabsJump";
    protected $btInterfaceWidth = "430";
    protected $btInterfaceHeight = "350";

    /*
      http://www.concrete5.org/community/forums/documentation_efforts/speed-up-your-site-with-block-caching/
     */
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = false;
    protected $btCacheBlockOutputOnPost = false;
    protected $btCacheBlockOutputForRegisteredUsers = true;

    public function getBlockTypeDescription()
    {
        return t('Inserts a button to jump forward, backward, first, last or to a specific tab in a set of magic tabs.');
    }

    public function getBlockTypeName()
    {
        return t('Jump to Magic Tab');
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

    public function extreme_sanitize($txt)
    {
        $th = Core::make('helper/text');
        return $th->filterNonAlphaNum($txt);
    }

    public function hrefify($txt)
    {
        return '#' . preg_replace("/^\#/", '', preg_replace("/\s+/", '', $txt));
    }

    /*
      Adapted from
      http://www.concrete5.org/documentation/how-tos/developers/obtain-a-unique-identifier-for-a-block/
     */
    public function get_block_identifier()
    {
        $th = Core::make('helper/text');
        $prefix = $th->filterNonAlphaNum($this->getBlockTypeName()) . '_';

        // its a copy, so use proxy id
        if ($this->getBlockObject()->getProxyBlock()) {
            return $prefix . $this->getBlockObject()->getProxyBlock()->getInstance()->getIdentifier();
        }

        // its a unique block, so use id
        return $prefix . $this->getIdentifier();
    }

}
