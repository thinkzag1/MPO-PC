<?php

namespace Concrete\Package\JlMagicTabs\Block\JlMagicTabs;

use Concrete\Core\Block\BlockController;
use Package;
use Page;
use Permissions;
use Core;
use Config;

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

    protected $btTable = "btJlMagicTabs";
    protected $btInterfaceWidth = "700";
    protected $btInterfaceHeight = "500";

    /*
      We catually need grid framework elements in view to render headings correctly
      during edit and while rendering!!

      http://www.concrete5.org/profile/messages/-/view_message/inbox/612935/
      http://www.concrete5.org/profile/messages/-/view_message/inbox/614147/

      These are removed during slicing & dicing, then any grid container re-applied
      later through tab proformas
     */
    protected $btIgnorePageThemeGridFrameworkContainer = false;

    public function getBlockTypeName()
    {
        $pkg = Package::getByHandle('jl_magic_tabs');
        return $pkg->getPackageName();
    }

    public function getBlockTypeDescription()
    {
        $pkg = Package::getByHandle('jl_magic_tabs');
        return $pkg->getPackageDescription();
    }

    /*
      Unfortunately providing help causes 5.7.4 RC1 to puke, so it
      is commented out until the core is fixed
      public function getBlockTypeHelp() {
      return $this->getBlockTypeDescription();
      }
      # */

    /*
      The set 'magic_tabs' has been added by the package controller
     */
    public function getBlockTypeDefaultSet()
    {
        return 'magic_tabs';
    }

    public function validate($data)
    {
        $error = Core::make('helper/validation/error');

        $data['heading'] = trim($data['heading']);
        if (empty($data['heading'])) {
            $error->add(t('Every tab needs a heading!'));
        }
        if (max(0, (int) $data['responsive_threshold']) != $data['responsive_threshold']) {
            $error->add(t('If set, the responsive threshold must be a positive integer.'));
        }

        if ($error->has()) {
            return $error;
        }
    }

    public function save($data)
    {
        /*
         * Global values
         */
        if(isset($data['global_params'])){
            foreach ($data['global_params'] as $k=>$v){
                Config::save('magic_tabs.global_param.'.$k, $v);
            }
        }
        
        /*
         * Block specific values
         */
        
        $data['responsive_threshold'] = max(0, (int) $data['responsive_threshold']);
        $data['heading'] = trim($data['heading']);
        $data['tip'] = trim($data['tip']);
       
        
        parent::save($data);
    }

    public function on_page_view()
    {
        /*
          We need jQuery. Later versions of C5 should have it loaded no matter what.
          Doesn't hurt to note it here, just to make sure
         */
        if (!$this->c5_already_loaded()) {
            $this->requireAsset('javascript', 'jquery');
        }

        /*
          Asset requirements vary by template.
          currently some css requirements, but none for js
         */
        $css_requirements = $this->template_asset_requirements();
        if (!empty($css_requirements) && is_array($css_requirements) && count($css_requirements) > 0) {
            if (in_array('ccm.app.css', $css_requirements)) {
                $this->requireAsset('css', 'core/app');
            }
            if (in_array('jquery.ui.css', $css_requirements)) {
                $this->requireAsset('css', 'jquery/ui');
            }
        }

        /*
          MT utilities used for slicing etc
         */
        $this->requireAsset('javascript', 'magicTabs/slice');
        if(!Page::getCurrentPage()->isEditMode()){
            $this->addHeaderItem('<style>.magic-tabs-hide{display:none;}</style>');
        }

        /*
         * Transition helper provides its own asset loading
         */
        if (!empty($this->transition_speed) && !Page::getCurrentPage()->isEditMode()) {
            $show_hide_helper = Core::make('helper/jl_show_hide');
            ;
            $show_hide_helper->required_assets($this, array('duration' => $this->transition_speed,
                'transition' => $this->transition_type,
                'direction' => $this->transition_direction,
                'easing' => $this->transition_easing,
                    )
            );
        }

        if ($this->tab_history && (int) $this->tab_history != 2) {
            $this->requireAsset('javascript', 'history');
        }
    }

    private function get_block_template_name()
    {
        $blockObject = $this->getBlockObject();
        if (is_object($blockObject)) {
            $template = $blockObject->getBlockFilename();
            if ($template) {
                return $template;
            }
        }
        // sometimes doesn't get returned by the above !!
        $db = \Database::get();
        $template = $db->getOne('SELECT bFilename FROM Blocks WHERE bID = ? ', array($this->bID));
        if ($template) {
            return $template;
        }
        return 'view';
    }

    private function template_asset_requirements()
    {
        $template = $this->get_block_template_name();
        $css_keys = array();

        if ($template == 'view') {
            $css_keys[] = 'ccm.app.css';
        }
        if ($template == 'ok_to_primary' || $template == 'rainbow' || $template == 'continued_rainbow') {
            $css_keys[] = 'ccm.app.css';
        }

        // supports own templates and 3rd parties
        if (preg_match("/_ui/i", $template) || preg_match("/ui_/i", $template)) {
            $css_keys[] = 'jquery.ui.css';
        }

        // in case of other party templates building on ccm.app
        if (preg_match("/_ccm/i", $template)) {
            $css_keys[] = 'ccm.app.css';
        }
        return array_unique($css_keys);
    }

    /*
      some asset already loaded if toolbar showing. Don't really need this test, but it does avoid some theme bugs
     */
    private function c5_already_loaded()
    {
        if (Page::getCurrentPage()->isEditMode()) {
            return true;
        }
        $cp = new Permissions(Page::getCurrentPage());
        if ($cp->canWrite()) {
            return true;
        }
        if ($cp->canAddSubContent()) {
            return true;
        }
        if ($cp->canAdminPage()) {
            return true;
        }
        return false;
    }

    public function add()
    {
        $this->set_everything();
        $this->set_global_options();
    }

    public function edit()
    {
        $this->set_everything();
        $this->set_global_options();
    }

    public function view()
    {
        $this->set_everything();
    }

    /*
      Return unformatted text for searching
     */
    public function getSearchableContent()
    {
        $th = Core::make('helper/text');
        return $text = $th->sanitize($this->heading . ' ' . $this->tip);
    }

    private function set_everything()
    {
        // unique id without spaces
        $th = Core::make('helper/text');
        $this->set('heading_id', $th->sanitizeFileSystem($this->heading));
    }

    private function set_global_options()
    {
         $ch = Core::make('helper/jl_magic_tabs_continuity');
         $this->set('global_params',$ch->get_all_global_params());
    }

    /*
      Implemented as callbacks to minimise impact on many existing templates.
     */
    public function get_nesting_level_option()
    {
        if (isset($this->level)) {
            $nesting_level_option = (int) $this->level;
        }
        if (empty($nesting_level_option)) {
            $nesting_level_option = 0;
        }
        return $nesting_level_option;
    }

    public function get_nesting_level_options()
    {
        return array(0 => t('Continue'),
            1 => t('Increase nesting'),
            2 => t('Decrease nesting'),
            10 => t('Outer level'),
            11 => t('Nested 1'),
            12 => t('Nested 2'));
    }

    public function get_nesting_level_options_label()
    {
        $la = $this->get_nesting_level_options();
        $lo = $this->get_nesting_level_option();
        return $la[$lo];
    }

    public function get_tab_continuity()
    {
        if (isset($this->tab_continuity)) {
            $tab_continuity = (int) $this->tab_continuity;
        }
        // default = on
        if (empty($tab_continuity)) {
            $tab_continuity = 1;
        }
        return $tab_continuity;
    }

}
