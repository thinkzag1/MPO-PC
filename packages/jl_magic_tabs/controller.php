<?php

namespace Concrete\Package\JlMagicTabs;

use Package;
use BlockType;
use Concrete\Core\Block\BlockType\Set;
use Loader;
use Core;
use AssetList;
use Concrete\Core\Asset\Asset;

defined('C5_EXECUTE') or die("Access Denied.");

/*
  Magic Tabs by John Liddiard (aka JohntheFish)
  www.jlunderwater.co.uk
  This software is licensed under the terms described in the concrete5.org marketplace.
  Please find the add-on there for the latest license copy.

  Create a tabbed interface simply by inserting magic tabs blocks into the page
 */

class Controller extends Package
{
    /*
      Used during development to facilitate updating
     */
    /*
      function __construct(){
      $this->pkgVersion = $this->pkgVersion.'.'.time();
      }
     */

    protected $pkgHandle = 'jl_magic_tabs';
    protected $appVersionRequired = '5.7.3.1';
    protected $pkgVersion = '7.1.2';

    public function getPackageDescription()
    {
        return t('Organise content into tabs.');
    }

    public function getPackageName()
    {
        return t('Magic Tabs');
    }

    public function install()
    {
        $pkg = parent::install();
        $this->install_or_upgrade($pkg);
    }

    public function upgrade()
    {
        parent::upgrade();
        $this->install_or_upgrade($this);
    }

    private function install_or_upgrade($me)
    {
        $this->make_block_set($me);
        $this->install_blocks($me);
        $this->adjust_block_display_order($me);
    }

    /*
      Clean up on uninstall
     */
    public function uninstall()
    {
        parent::uninstall();
        $db = \Database::get();
        foreach ($this->list_blocks() as $bt_handle => $bt_table) {
            $db->Execute('DROP TABLE IF EXISTS ' . $bt_table);
        }
    }

    /*
      List the blocks in the package and install them
     */
    private function install_blocks($me)
    {
        foreach ($this->list_blocks() as $bt_handle => $bt_table) {
            if (!is_object(BlockType::getByHandle($bt_handle))) {
                BlockType::installBlockType($bt_handle, $me);
            }
        }
    }

    /*
      With a bunch of related blocks I want my own set
     */
    private function make_block_set($me)
    {
        if (!is_object(Set::getByHandle('magic_tabs'))) {
            Set::add('magic_tabs', t('Magic Tabs'), $me);
        }
    }

    /*
      Adjust block display order to what I want - that I declare the blocks in.
      Doesn't appear to be an API for this

      $me is not currently used, but is here for consitency
      and in case the core provides an api in the future
     */
    private function adjust_block_display_order($me)
    {

        $bts = Set::getByHandle('magic_tabs');
        if (!is_object($bts)) {
            return;
        }

        $btsID = $bts->getBlockTypeSetID();
        $db = \Database::get();
        $order = 0;

        foreach ($this->list_blocks() as $bt_handle => $bt_table) {
            $bt = BlockType::getByHandle($bt_handle);
            if (!is_object($bt)) {
                continue;
            }
            $btID = $bt->getBlockTypeID();
            $db->Execute('UPDATE BlockTypeSetBlockTypes SET displayOrder = ? WHERE btID = ? and btsID = ?', array($order, $btID, $btsID));
            $order++;
        }
    }

    /*
      A list of blocks against tables. Used to install and uninstall
     */
    private function list_blocks()
    {
        $blocks = array(
            'jl_magic_tabs' => 'btJlMagicTabs',
            'jl_magic_tabs_end' => 'btJlMagicTabsEnd',
            'jl_magic_tabs_jump' => 'btJlMagicTabsJump',
            'jl_magic_tabs_auto_play' => 'btJlMagicTabsAutoPlay',
        );
        return $blocks;
    }

    /*
      Need to register assets and helpers each time a page is loaded
     */
    public function on_start()
    {
        $slice_script ='jl_magic_slice.min.js';
        //$slice_script = 'jl_magic_slice.txt.js';

        $show_hide_script = 'jl_show_hide_helper.min.js';
        //$show_hide_script = 'jl_show_hide_helper.js';

        /*
         *  Register assets
         */
        $al = AssetList::getInstance();

        $al->register('javascript', 'magicTabs/slice', 'js/' . $slice_script, array('version' => $this->pkgVersion,
            'position' => Asset::ASSET_POSITION_FOOTER,
            'minify' => false,
            'combine' => false), $this
        );

        $al->register('javascript', 'magicTabs/show-hide', 'js/' . $show_hide_script, array('version' => $this->pkgVersion,
            'position' => Asset::ASSET_POSITION_FOOTER,
            'minify' => false,
            'combine' => false), $this
        );

        $al->register('javascript', 'history', 'js/browserstate-history-js/jquery.history.min.js', array('version' => '1.8b2',
            'position' => Asset::ASSET_POSITION_FOOTER,
            'minify' => false,
            'combine' => false), $this
        );


        $al->register('javascript', 'easing', 'js/easing/jquery.easing.1.3.js', array('version' => '1.3',
            'position' => Asset::ASSET_POSITION_FOOTER,
            'minify' => false,
            'combine' => false), $this
        );


        $al->register('javascript', 'animate/enhanced', 'js/animate-enhanced/jquery.animate-enhanced.min.js', array('version' => '1.11',
            'position' => Asset::ASSET_POSITION_FOOTER,
            'minify' => false,
            'combine' => false), $this
        );

        $al->register('javascript', 'animation/frame', 'js/request_animation_frame/jquery.requestAnimationFrame.js', array('version' => '0.1.2',
            'position' => Asset::ASSET_POSITION_FOOTER,
            'minify' => false,
            'combine' => false), $this
        );



        // Register helpers

        /*
          v6.2.1 had to change these paths and namespaces
          https://github.com/concrete5/concrete5-5.7.0/issues/2169#issuecomment-94285776
          Having promised that 5.7 was the last breaking update, 5.7.4RC1 does it again
         */
        Core::bind(
                'helper/jl_show_hide', function () {
            return new \Concrete\Package\JlMagicTabs\Src\Helpers\JlShowHide;
        }
        );
        Core::bind(
                'helper/jl_magic_tabs_continuity', function () {
            return new \Concrete\Package\JlMagicTabs\Src\Helpers\JlMagicTabsContinuity;
        }
        );
    }

}
