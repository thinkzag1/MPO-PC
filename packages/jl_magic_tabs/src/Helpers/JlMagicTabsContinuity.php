<?php

namespace Concrete\Package\JlMagicTabs\Src\Helpers;

use Page;
use Core;
use Cookie;
use Config;

defined('C5_EXECUTE') or die("Access Denied.");
/*
  Magic Tabs by John Liddiard (aka JohntheFish)
  www.jlunderwater.co.uk
  This software is licensed under the terms described in the concrete5.org marketplace.
  Please find the add-on there for the latest license copy.

  Create a tabbed interface simply by inserting magic tabs blocks into the page
 */

class JlMagicTabsContinuity
{
    /*
     * 5.6 to 5.7 portability
     * Should respond to core versions 5.7+, while allowing code to be used 
     * with minimal changes for 5.6
     */
    public function get_cookie($name)
    {
        if ($this->is_57() && class_exists('Cookie')) {
            return Cookie::get($name);
        }
        return $_COOKIE[$name];
    }

    public function make_text_helper(){
        if($this->is_57()){
            return Core::make('helper/text');
        } else {
           return  Loader::helper('text');
        }
    }
    
    /*
     * Assist tab propagation from URL if it is enabled. Browsers and c5 can be dodgy
     * for working with the fragment on the server, so also send flag 'on' which tells
     * the javascript to try and do it.
     * 
     * It would be too fussy to do this the 5.7 way
     */
    public function get_url_tab()
    {
        if ($this->get_param('tab_url') != 'off') {
            $url_parts = parse_url($_SERVER['REQUEST_URI']);
            if (isset($url_parts['fragment'])) {
                return $url_parts['fragment'];
            }
            if (isset($_GET['tab'])) {
                return $_GET['tab'];
            }
            if (isset($_POST['tab'])) {
                return $_POST['tab'];
            }
            return 'on';
        }
        return 'off';
    }
    
    
    
    /*
     * Are we in 5.7
     */
    public function is_57()
    {
        return (defined('APP_VERSION') && version_compare(APP_VERSION, '5.7', 'ge'));
    }

    /*
     * 5.7 config or null
     */
    public function get_config($symbol)
    {
        if (!$this->is_57()) {
            return;
        }
        if (!class_exists('Config')) {
            return;
        }
        return Config::get($symbol);
    }

    /*
     * Track through all tab views on a page/request
     */

    public static $cval = array();

    public function __construct()
    {
        $this->set_global_defaults();
    }

    /*
     * Maintain continuity from one block to the next
     */
    public function update_continuity($area, $nesting_level_option = 0, $tab_continuity = 0)
    {

        /*
         * Adapt to being passed an area object or an area handle
         *
         * Updated for 5.7 to take an area object in preference to a handle,
         * but remain backward	compatible with 5.6 versions of MT and in particular user custom templates.
         * We can now use that to extract grid information
         */
        if (is_object($area)) {
            $area_obj = $area;
            $area = $area_obj->getAreaHandle();
        }
        /*
         * Start counting all tabs
         * Special processing for first tab on page (also includes some script later)
         */
        if (empty(self::$cval) ||
                !is_array(self::$cval) ||
                empty(self::$cval['global_count'])
        ) {
            self::$cval['global_count'] = 1;
            /*
             * at the start of the first tab on a page, sort out some global options
             */
            $this->set_global_defaults();
        } else {
            /*
             * continue global counting for all tabs
             */
            self::$cval['global_count'] ++;
        }

        /*
         * new area resets most stuff - except global count as per above
         */
        if (empty(self::$cval['current_area']) ||
                self::$cval['current_area'] != $area
        ) {

            self::$cval['current_area'] = $area;
            self::$cval['area_obj'] = $area_obj;

            self::$cval['nesting_group_count'] = 0;
            self::$cval['nesting_level'] = 0;
        }

        /*
         * Translate a nesting level command into
         * an actual level.
         */
        $nesting_level = $this->translate_nesting_level_option($nesting_level_option);


        /*
         * Need to track/count sets used for each actual nesting level, as this makes sure a 
         * setname is unique
         */
        if (empty(self::$cval['setcount'][$nesting_level])) {
            self::$cval['setcount'][$nesting_level] = 1;
        }


        /*
         *  hysteresis based on nesting level changes
         */
        if (empty(self::$cval['nesting_group_count'])) {
            self::$cval['nesting_group_count'] = 0;
        }
        if ($nesting_level > self::$cval['nesting_level']) {
            self::$cval['nesting_group_count'] ++;
        }


        /*
         * make sure that setname is unique if a new tabset is started within an area
         * At this point, setname is a working value and is not saved globally
         */
        $setname = $this->make_setname($area, $nesting_level);

        /*
         * going to a lower levem means the level we are exiting is
         * now closed and we go back to the previous set name
         */
        if ($nesting_level < self::$cval['nesting_level']) {
            //self::$cval['sets'][self::$cval['setname']]['tab_count'] = 9999;
            $this->endset($nesting_level + 1);
            $setname = $this->make_setname($area, $nesting_level);
        }


        /*
         *  track previous tab nesting level
         */
        self::$cval['nesting_level'] = $nesting_level;
        self::$cval['setname'] = $setname;

        /*
         *  we are starting a new tab set
         */
        if (empty(self::$cval['sets'][$setname]['tab_count'])) {
            self::$cval['sets'][$setname]['tab_count'] = 1;
            self::$cval['sets'][$setname]['nesting_level'] = $nesting_level;

            /*
             * Defaults for a new tabset
             */
            $this->set_tabset_defaults();

            /*
             * at the start of a set, maybe adjust continuity setting
             * defaults to 'on'
             */
            if (!empty($tab_continuity)) {
                if ($tab_continuity == 2) {
                    $this->set_param('tab_continuity', 'off');
                } else {
                    $this->set_param('tab_continuity', 'on');
                }
            }
        } else {
            /*
             *  set not ended, so count another tab within a set
             */
            self::$cval['sets'][$setname]['tab_count'] ++;
        }
    }

    /*
     * Create the setname, taking nesting and tabset count into consideration
     */
    private function make_setname($area, $nesting_level)
    {
        $setname = $this->sanitize('jl_magic_tabs_' . $area);
        if ($nesting_level > 0) {
            $setname = $setname . '_n' . $nesting_level;
        }
        $setname .='_s' . self::$cval['setcount'][$nesting_level];

        /*
         * A tab_count >= 9999 means a set is closed, so a new setname is needed
         */
        while (self::$cval['sets'][$setname]['tab_count'] >= 9999) {
            // count that we need another set
            self::$cval['setcount'][$nesting_level] ++;
            $setname = $this->sanitize('jl_magic_tabs_' . $area);
            // make sure that setname is unique if a group is getting subdivided by nested tabs
            if ($nesting_level > 0) {
                $setname = $setname . '_n' . $nesting_level;
            }
            $setname .='_s' . self::$cval['setcount'][$nesting_level];
        }

        return $setname;
    }

    /*
     * Various defaults. 
     * Can be set by site constants or by set_param in block templates
     * Adaptive to 5.7 or 5.6 and even use of 5.6 definitions in a 5.7 site
     */
    private function set_global_defaults()
    {

        if ($this->global_params_already_set()) {
            return;
        }

        /*
          Enable url linking into tabs and internal links.

          default to 'on'
         */
        if (( defined('JL_MAGIC_TABS_ENABLE_TAB_URL') && !JL_MAGIC_TABS_ENABLE_TAB_URL ) ||
                ( $this->get_config('magic_tabs.global_param.enable_tab_url') )
        ) {
            $this->set_global_param('tab_url', 'off');
        } else {
            $this->set_global_param('tab_url', 'on');
        }

        /*
         * Enable auto showing of hidden blocks, used to remove FOUC during tab initialisation
         *
         * default to 1 = true = 'on'
         */


        if (defined('JL_MAGIC_TABS_ENABLE_AUTO_SHOW') && !JL_MAGIC_TABS_ENABLE_AUTO_SHOW) {
            $this->set_global_param('auto_show', 0);
        } else if ($this->get_config('magic_tabs.global_param.auto_show') !== null) {
            $this->set_global_param('auto_show', $this->get_config('magic_tabs.global_param.auto_show'));
        } else {
            $this->set_global_param('auto_show', 1);
        }

        /*
          Enable diagnostics mode. Will put boxes round tab bodies and show copious
          traces to the console.log

          default to 0 = false
         */
        if (( defined('JL_MAGIC_TABS_ENABLE_DIAGNOSTICS') && JL_MAGIC_TABS_ENABLE_DIAGNOSTICS ) ||
                ( $this->get_config('magic_tabs.global_param.enable_diagnoistics') )
        ) {
            $this->set_global_param('diagnostics_enabled', 1);
        } else {
            $this->set_global_param('diagnostics_enabled', 0);
        }

        /*
          When in accordion mode, if no initial tab is selected, open the default (first) item.
          Default is that the accordion is rendered closed.

          default to 0 = false
         */
        if (( defined('JL_MAGIC_TABS_ACCORDION_DEFAULT_OPEN') && JL_MAGIC_TABS_ACCORDION_DEFAULT_OPEN ) ||
                ( $this->get_config('magic_tabs.global_param.accordion_default_open') )
        ) {
            $this->set_global_param('accordion_default_open', 1);
        } else {
            $this->set_global_param('accordion_default_open', 0);
        }

        /*
         * When in accordion mode, ensure that one tab is always open, so that a tab can't close itself.
         * Default is that its possible to have a completely closed accordion.
         *
         * If you change accordion_always_open, you will need to develop appropriate custom templates
         * with minor tweaks to accordion css.
         *
         * default to 0 = false
         */
        if (( defined('JL_MAGIC_TABS_ACCORDION_ALWAYS_OPEN') && JL_MAGIC_TABS_ACCORDION_ALWAYS_OPEN ) ||
                ( $this->get_config('magic_tabs.global_param.accordion_always_open') )
        ) {
            $this->set_global_param('accordion_always_open', 1);
        } else {
            $this->set_global_param('accordion_always_open', 0);
        }


        /*
         * On mobile devices, option to not render any transitions
         */
        if (( defined('JL_MAGIC_TABS_MOBILE_NO_TRANSITIONS') && JL_MAGIC_TABS_MOBILE_NO_TRANSITIONS ) ||
                ( $this->get_config('magic_tabs.global_param.mobile_no_transitions') )
        ) {
            $this->set_global_param('mobile_no_transitions', 1);
        } else {
            $this->set_global_param('mobile_no_transitions', 0);
        }

        /*
         * When resolving tab content, MT climbs up levels of DOM elements to find a common ancestor for a set of tabs.
         * This is by default limited to 5 levels, but may need to be more if a theme wraps blocks in multiple levels 
         * of DOM elements.
         */
        if (defined('JL_MAGIC_TABS_MAX_ANCESTOR_LEVELS') && JL_MAGIC_TABS_MAX_ANCESTOR_LEVELS) {
            $this->set_global_param('max_ancestor_levels', JL_MAGIC_TABS_MAX_ANCESTOR_LEVELS);
        } else if ($this->get_config('magic_tabs.global_param.max_ancestor_levels') !== null) {
            $this->set_global_param('max_ancestor_levels', $this->get_config('magic_tabs.global_param.max_ancestor_levels'));
        } else {
            $this->set_global_param('max_ancestor_levels', 5);
        }

        /*
         * Preserve the grid box model. If set false, MT wrapped blocks are climbed out of
         * levels of wrapping dom boxes.
         * defauts to true;
         */
        if (defined('JL_MAGIC_TABS_PRESERVE_GRID_BOX') && !JL_MAGIC_TABS_PRESERVE_GRID_BOX) {
            $this->set_global_param('preserve_grid_box', 0);
        } else if ($this->get_config('magic_tabs.global_param.preserve_grid_box') !== null) {
            $this->set_global_param('preserve_grid_box', $this->get_config('magic_tabs.global_param.preserve_grid_box'));
        } else {
            $this->set_global_param('preserve_grid_box', 1);
        }

        /*
         * Whether to wrap the entire tabset structure in a theme grid box.
         * defauts to false;
         */
        if (( defined('JL_MAGIC_TABS_WRAP_WITH_GRID_BOX') && JL_MAGIC_TABS_WRAP_WITH_GRID_BOX ) ||
                ( $this->get_config('magic_tabs.global_param.wrap_with_grid_box') )
        ) {
            $this->set_global_param('wrap_with_grid_box', 1);
        } else {
            $this->set_global_param('wrap_with_grid_box', 0);
        }


        /*
          Enable diagnostics mode for auto play. This is separate from tabs diagnostics because
          it can get extremely verbose for traces to the console.log

          default to 0 = false
         */
        if (( defined('JL_MAGIC_TABS_ENABLE_AUTOPLAY_DIAGNOSTICS') && JL_MAGIC_TABS_ENABLE_AUTOPLAY_DIAGNOSTICS ) ||
                ( $this->get_config('magic_tabs.global_param.enable_autoplay_diagnostics') )
        ) {
            $this->set_global_param('autoplay_diagnostics_enabled', 1);
        } else {
            $this->set_global_param('autoplay_diagnostics_enabled', 0);
        }

        /*
          Enable diagnostics mode for auto play. This is separate from tabs diagnostics because
          it can get extremely verbose for traces to the console.log

          default to 0 = false
         */
        if (defined('JL_MAGIC_TABS_GRID_CLASSES_TO_REMOVE')
        ) {
            $this->set_global_param('grid_classes_to_remove', JL_MAGIC_TABS_GRID_CLASSES_TO_REMOVE);
        } else if ($this->get_config('magic_tabs.global_param.grid_classes_to_remove') !== null) {
            $this->set_global_param('grid_classes_to_remove', $this->get_config('magic_tabs.global_param.grid_classes_to_remove'));
        } else {
            /*
             * Default 'container' is appropriate for bootstrap themes
             */
            $this->set_global_param('grid_classes_to_remove', 'container');
        }

        //possibly further defaults created here
    }

    private function set_tabset_defaults()
    {

        if ($this->params_already_set()) {
            return;
        }

        //default to 'immediate'

        if (( defined('JL_MAGIC_TABS_INSERT_LOCATION') && JL_MAGIC_TABS_INSERT_LOCATION == 'top' ) ||
                ( $this->get_config('magic_tabs.global_param.insert_location') == 'top' )
        ) {
            $this->set_param('insert_location', 'top');
        } else {
            $this->set_param('insert_location', 'immediate');
        }

        if (( defined('JL_MAGIC_TABS_CONTINUITY') && JL_MAGIC_TABS_CONTINUITY == 'off' ) ||
                ( $this->get_config('magic_tabs.global_param.continuity') == 'off' )
        ) {
            $this->set_param('tab_continuity', 'off');
        } else {
            $this->set_param('tab_continuity', 'on');
        }
    }

    /*
      better sanitize to allow for punctuation that C5 does not.
     */
    private function sanitize($t)
    {
        $th = $this->make_text_helper();
        return preg_replace("/[^a-z0-9]+/i", '_', $th->sanitizeFileSystem($t));
    }

    /*
      Translate a nesting level command into
      an actual level.
     */
    public function translate_nesting_level_option($nesting_level_option = 0)
    {

        // no current level, so outer
        if (empty(self::$cval['nesting_level'])) {
            self::$cval['nesting_level'] = 0;
        }

        // 0, default = continue
        if (empty($nesting_level_option)) {
            $nesting_level = self::$cval['nesting_level'];

            // 1, increase
        } else if ($nesting_level_option == 1) {
            $nesting_level = min(2, self::$cval['nesting_level'] + 1);

            // 2, decrease
        } else if ($nesting_level_option == 2) {
            $nesting_level = max(0, self::$cval['nesting_level'] - 1);

            // explicitly set level
        } else if ($nesting_level_option == 10) {
            $nesting_level = 0;
        } else if ($nesting_level_option == 11) {
            $nesting_level = 1;
        } else if ($nesting_level_option == 12) {
            $nesting_level = 2;

            // default to continue current level
        } else {
            $nesting_level = self::$cval['nesting_level'];
        }
        return $nesting_level;
    }

    public function get_tab_ix()
    {
        $setname = $this->get_setname();
        return self::$cval['sets'][$setname]['tab_count'];
    }

    public function get_global_ix()
    {
        return self::$cval['global_count'];
    }

    public function get_heading_id($hid)
    {
        return $this->sanitize($hid) . '_gix' . $this->get_global_ix();
    }

    public function get_set_ix()
    {
        $setname = $this->get_setname();
        $set_ix = array_keys(self::$cval['sets']);
        $offset = array_search($setname, $set_ix) + 1;
        return $offset;
    }

    /*
     * Set and get for local tab params and global tab params.
     * Used both to provide overrides from code of the defaults
     * above and for general parameter communication that is sticky
     * between tabs.
     */
    public function set_param($param, $code)
    {
        $setname = $this->get_setname();
        self::$cval['sets'][$setname][$param] = $code;
        return;
    }

    public function get_param($param)
    {
        $setname = $this->get_setname();
        if (!empty(self::$cval['sets'][$setname][$param])) {
            return self::$cval['sets'][$setname][$param];
        }
        return;
    }

    public function set_global_param($param, $code)
    {
        self::$cval['global_parameters'][$param] = $code;
        return;
    }

    public function get_global_param($param)
    {
        if (!empty(self::$cval['global_parameters'][$param])) {
            return self::$cval['global_parameters'][$param];
        }
        return;
    }

    public function get_all_global_params()
    {
        if (!empty(self::$cval['global_parameters'])) {
            return self::$cval['global_parameters'];
        }
        return;
    }

    /*
     * Has anything already been set?
     */
    public function params_already_set()
    {
        $setname = $this->get_setname();
        if (is_array(self::$cval['sets'][$setname])) {
            return true;
        }
    }

    public function global_params_already_set()
    {
        if (is_array(self::$cval['global_parameters'])) {
            return true;
        }
    }

    /*
     * Simply return the current setname
     */
    public function get_setname()
    {
        if ($this->in_edit_or_admin()) {
            return false;
        }
        return self::$cval['setname'];
    }

    /*
     * Simply return the current nesting level
     */
    public function get_nesting_level()
    {
        if (!empty(self::$cval['nesting_level'])) {
            return self::$cval['nesting_level'];
        }
        return 0;
    }

    /*
     * Retrieve the last displayed tab from the cookie, so preserving continuity
     * when pages are refreshed.
     */
    public function get_current_tab()
    {
        if ($this->get_param('tab_continuity') && $this->get_param('tab_continuity') != 'off') {
            $setname = $this->get_setname();
            if (empty($setname)) {
                return;
            }
            $cID = Page::getCurrentPage()->getCollectionID();
            $current_tab = $this->get_cookie($setname . '-' . $cID);

            return $current_tab;
        }
    }


    /*
     * Show proforma if its the first time through for the set, so we
     * get 1 proforma rendered for each set
     */
    public function show_proforma()
    {
        if ($this->in_edit_or_admin()) {
            return false;
        }
        $setname = $this->get_setname();
        if (empty($setname)) {
            return true;
        } else if (!empty(self::$cval['sets'][$setname]['tab_count']) &&
                self::$cval['sets'][$setname]['tab_count'] < 2
        ) {
            return true;
        }
        return false;
    }

    /*
     * Script is only needed once per page, first set and with the first tab
     * and only when not in edit or admin
     */
    public function include_script()
    {

        if ($this->in_edit_or_admin()) {
            return false;
        }

        if (!$this->get_setname()) {
            return false;
        }

        if (self::$cval['global_count'] != 1) {
            return false;
        }

        return true;
    }

    /*
     * Edit or admin or stack view etc, all in one handy test
     */
    public function in_edit_or_admin()
    {
        $page = Page::getCurrentPage();
        if ($page->isEditMode()) {
            return true;
        }
        if ($page->isAdminArea()) {
            return true;
        }
        $path = $page->getCollectionPath();
        if (strpos($path, '/dashboard/') !== false) {
            return true;
        }
        if (strpos($path, '!stacks') !== false) {
            return true;
        }
        return false;
    }

    /*
     * End a set of tabs by setting its count ridiculously high
     */
    public function endset($nesting_level = 0)
    {
        $setname = $this->get_setname();
        if (empty($setname)) {
            return;
        }

        if (is_array(self::$cval['sets']) &&
                is_array(self::$cval['sets'][$setname])
        ) {
            /*
             * always end the current set
             */
            self::$cval['sets'][$setname]['tab_count'] = 9999;
            /*
             * and any sets at the current level or higher
             */
            foreach (self::$cval['sets'] as $sn => $setinfo) {
                if ($setinfo['nesting_level'] >= $nesting_level) {

                    /*
                     * Set count at that level increases
                     */
                    if (self::$cval['sets'][$setname]['tab_count'] < 9999) {
                        self::$cval['setcount'][$setinfo['nesting_level']] ++;
                    }

                    /*
                     * End the nested set
                     */
                    self::$cval['sets'][$sn]['tab_count'] = 9999;
                }
            }
        }
        /*
         * Set the level to what it needs to be after this block.
         * ie, lower than current !!
         */
        self::$cval['nesting_level'] = $nesting_level;
    }

    /*
     * Returns an array of available heading levels
     * Heading levels used for tabs before script rearranges them
     * defaults to h3, h4, h5
     * Can be overriden by a config constant
     */
    public function heading_levels()
    {
        $hl = array(3, 4, 5);

        if ($this->is_57() && $this->get_config('magic_tabs.global_param.heading_levels')) {
            $hlw = $this->get_config('magic_tabs.global_param.heading_levels');
        } else if (defined('JL_MAGIC_TABS_HEADING_LEVELS')) {
            $hlw = 'JL_MAGIC_TABS_HEADING_LEVELS';
        }
        if (!empty($hlw)) {
            if (!is_array($hlw)) {
                $hlw = preg_replace("/[^1-6]+/", ',', $hlw);
                $hlw = preg_replace("/^[^1-6]+/", '', $hlw);
                $hlw = preg_replace("/[^1-6]+$/", '', $hlw);
                $hlw = explode(',', $hlw);
            }
            foreach (array_values($hlw) as $nl => $hlv) {
                $hl[$nl] = $hlv;
            }
        }
        return $hl;
    }

    /*
     * Builds id for embedding in tab heading
     */
    public function id_attribute_text($heading_id)
    {
        return 'id="jl_magic_tabs_' . $this->get_heading_id($heading_id) . '"';
    }

    /*
     * Builds data for embedding in tab heading that is used to communicate with js
     * when setting up tabs.
     */
    public function data_attribute_text($controller)
    {
        ob_start()
        ?>
        data-jl-mt-setname="<?php echo $this->get_setname(); ?>"
        data-jl-mt-level="<?php echo $this->get_nesting_level(); ?>"
        data-jl-mt-insert-location="<?php echo $this->get_param('insert_location'); ?>"
        <?php
        $current_tab = $this->get_current_tab();
        if (!empty($current_tab)) {
            echo ' data-jl-mt-current-tab="' . $current_tab . '"';
        }
        ?>
        <?php
        if ($this->get_param('tab_continuity') && $this->get_param('tab_continuity') != 'off') {
            echo ' data-jl-mt-continuity="1"';
        }
        ?>
        <?php
        if ($this->get_param('tab_history') && $this->get_param('tab_history') != 'off') {
            echo ' data-jl-mt-history="1"';
        }
        ?>
        <?php
        if ((int) $controller->responsive_threshold > 0) {
            echo ' data-jl-mt-responsive-threshold="' . (int) $controller->responsive_threshold . '"';
        }

        /*
         * transition parameters, ignored unless first in set
         */
        if (!empty($controller->transition_speed)) {
            ?>
            data-jl-mt-transition-speed="<?php echo $controller->transition_speed; ?>"
            data-jl-mt-transition-type="<?php echo $controller->transition_type; ?>"
            data-jl-mt-transition-easing="<?php echo $controller->transition_easing; ?>"
            data-jl-mt-transition-direction="<?php echo $controller->transition_direction; ?>"
            <?php
            if ($controller->transition_adaptive_dir == 'Y') {
                echo ' data-jl-mt-transition-adapt-dir="1"';
            }
        }
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    /*
     * Builds classes for embedding in tab heading
     */
    public function class_attribute_text($controller)
    {
        $classes = array(
            'jl_magic_tabs',
            $this->get_setname(),
            'jl_magic_tabs_level_' . $this->get_nesting_level(),
            'jl_magic_tabs_ix_' . $this->get_tab_ix(),
            'jl_magic_tabs_gix_' . $this->get_global_ix(),
        );
        return 'class="' . implode(' ', $classes) . '"';
    }

    /*
     * Utility for development and testing diagnostics
     */
    public function debug_data($format = false)
    {
        $data = self::$cval;
        $data['area_obj'] = '**recursion prevented**';
        if ($format) {
            return print_r($data, true);
        }
        return $data;
    }

}
