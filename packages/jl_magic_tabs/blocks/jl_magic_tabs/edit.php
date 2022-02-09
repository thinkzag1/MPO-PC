<?php
defined('C5_EXECUTE') or die('Access Denied.');

/*
  Magic Tabs by John Liddiard (aka JohntheFish)
  www.jlunderwater.co.uk
  This software is licensed under the terms described in the concrete5.org marketplace.
  Please find the add-on there for the latest license copy.

  Create a tabbed interface simply by inserting magic tabs blocks into the page
 */

$form = Core::make('helper/form');
$ch = Core::make('helper/jl_magic_tabs_continuity');
?>
<div id="jl-magic-tabs-edit">
    <?php
    /*
      http://www.concrete5.org/documentation/how-tos/developers/using-tabbed-panels-in-concrete5-5.7/
     */
    echo Core::make('helper/concrete/ui')->tabs(array(
        array('basic_settings', t('Basic Settings'), true),
        array('advanced_settings', t('Advanced Settings')),
        array('transitions', t('Transitions')),
        array('global_parameters', t('Global Settings')),
        array('help', t('Help')),
    ));
    ?>
    <div id="ccm-tab-content-basic_settings" class="ccm-tab-content">
        <div class="form-group">
            <?php
            echo $form->label('heading', t('Tab Heading:'));
            echo $form->text('heading', $heading, array('maxlength' => 255, 'class' => 'form-control'));
            ?>
            <div class="alert alert-info" style="margin-top:15px">
                <?php
                echo t('To get started, the only required field is the tab heading above. You can ignore the rest of this edit dialog. Place one Magic Tabs block where you want a set of tabs to start, then further Magic Tabs blocks for each tab. You can place any block or stack between Magic Tabs blocks to provide the content of each tab. A set of tabs needs at least two Magic Tabs blocks.');
                ?>
            </div>
        </div>
        <div class="form-group">
            <?php
            echo $form->label('tip', t('Optional tip:'));
            echo $form->textarea('tip', $tip, array('maxlength' => 1000, 'class' => 'form-control'));
            ?>
        </div>
    </div>

    <div id="ccm-tab-content-advanced_settings" class="ccm-tab-content">

        <div class="form-group clearfix" >
            <div class="alert alert-info">
                <?php
                echo t('Nested tabs automatically begin at the outer level. If you don\'t need to create nested tab sets, simply leave this option alone.');
                ?>
            </div>
            <div class="form-horizontal">
                <?php
                echo $form->label('level', t('Optional nesting level:'), array('class' => 'col-sm-6'));
                // level - defaults to null/0/continue
                if (empty($level)) {
                    $level = 0;
                }
                ?>
                <div class="col-sm-5">
                    <?php
                    echo $form->select('level', $controller->get_nesting_level_options(), $level);
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group clearfix">
            <div class="alert alert-info">
                <?php
                echo t('Tab continuity remembers the currently open tab when a page is re-visited. This setting is edited with the first tab in a set and is ignored for subsequent tabs in a set.');
                ?>
            </div>

            <div class="form-horizontal">
                <?php
                echo $form->label('tab_continuity', t('Tab continuity:'), array('class' => 'col-sm-6'));
                /*
                  selection uses null/1/2 to account for previous version of MT where null = default, so
                  allowing un-edited tabs from previuous versions to continue as before without
                  any code changes to templates.
                 */

                $option_on_off = array(1 => t('Continuity on'), 2 => t('Continuity off'));
                if (empty($tab_continuity)) {
                    $tab_continuity = 1; // defaults to ON
                }
                ?>
                <div class="col-sm-5">
                    <?php
                    echo $form->select('tab_continuity', $option_on_off, $tab_continuity);
                    ?>
                </div>
            </div>
        </div>


        <div class="form-group clearfix">
            <div class="alert alert-info">
                <?php
                echo t('Tab history tracks tabs and associates browser back/forward buttons with tabs. The url is adjusted to match and the page title may also be adjusted. This setting is edited with the first tab in a set and is ignored for subsequent tabs in a set.');
                ?>
            </div>

            <div class="form-horizontal">
                <?php
                echo $form->label('tab_continuity', t('Tab history:'), array('class' => 'col-sm-6'));
                /*
                  selection uses null/1/2 to account for previous version of MT where null = default, so
                  allowing un-edited tabs from previuous versions to continue as before without
                  any code changes to templates.

                  Strictly speaking, this could be done with a simple checkbox. However, the select allows for
                  more complex behaviours to be added in the future.
                 */

                $history_options = array(1 => t('History on'), 2 => t('History off'));
                if (empty($tab_history)) {
                    $tab_history = 2; // defaults to off
                }
                ?>
                <div class="col-sm-5">
                    <?php
                    echo $form->select('tab_history', $history_options, $tab_history);
                    ?>
                </div>
            </div>
        </div>


        <div class="form-group clearfix">
            <div class="alert alert-info">
                <?php
                echo t('Responsive behaviour will render a tab set as an accordion when the browser window or screen size is below a threshold width (some templates may not work with accordion behaviour).');
                ?>
            </div>

            <div class="form-horizontal clearfix">
                <?php
                echo $form->label('responsive_threshold', t('Responsive Threshold (px):'), array('class' => 'col-sm-6'));
                /*
                  Threshold, constrained to a positive number.
                 */
                $responsive_threshold = (int) $responsive_threshold;
                if (empty($responsive_threshold)) {
                    $responsive_threshold = 0;
                }
                ?>
                <div class="col-sm-5">
                    <?php
                    echo $form->number('responsive_threshold', $responsive_threshold, array('min' => 0, step => 1, 'class' => 'number_input'));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group clearfix">
            <div class="alert alert-info">
                <dl>
                    <dt>
                        <?php
                        echo t('Tip');
                        ?>
                    </dt>
                    <dd>
                        <?php
                        echo t('You can always render an accordion by setting the value to something arbitrarily large. The best transition to use with an accordion is the basic \'Slide up/down\'. ');
                        ?>
                    </dd>
                </dl>
            </div>

        </div>


    </div>


    <div id="ccm-tab-content-transitions" class="ccm-tab-content">

        <div class="form-group clearfix">
            <div class="alert alert-info">
                <?php
                echo t('Transitions are optional. The transition used by a tab set is set by the first tab in a set and is ignored for subsequent tabs in a set.');
                ?>
            </div>
        </div>
        <?php
        $show_hide_helper = Core::make('helper/jl_show_hide');
        echo $show_hide_helper->edit_control(array('duration' => $transition_speed,
            'duration_key' => 'transition_speed',
            'transition' => $transition_type,
            'transition_key' => 'transition_type',
            'direction' => $transition_direction,
            'direction_key' => 'transition_direction',
            'easing' => $transition_easing,
            'easing_key' => 'transition_easing',
            'adaptive_dir' => $transition_adaptive_dir,
            'adaptive_dir_key' => 'transition_adaptive_dir',
                )
        );
        ?>
        <div class="form-group clearfix">
            <div class="alert alert-info">
                <dl>
                    <dt><?php echo t('Tip'); ?></dt>
                    <dd>
                        <?php
                        echo t('More information about various easing functions can be found at %shttp://easings.net/%s.', '<a href="http://easings.net/">', '</a>'
                        );
                        ?>
                    </dd>
                </dl>
            </div>
        </div>


    </div>
    <div id="ccm-tab-content-global_parameters" class="ccm-tab-content">
        <div class="alert alert-warning">
            <?php
            echo t('These parameters are global settings across <b>all Magic Tabs blocks</b>. They can be used to adapt the behaviour of Magic Tabs to work best with your site requirements and theme.');
            ?>
        </div>
        <div class="form-group clearfix">
            <div class="alert alert-info">
                <?php
                echo t('How accordions behave.');
                ?>
            </div>
            <div class="form-horizontal">
                <?php
                /*
                 * When in accordion mode, the default state is all tabs closed. 
                 * Setting this will default to one tab open, usually the first.
                 */
                echo $form->label('global_params[accordion_default_open]', t('Accordion initial state:'), array('class' => 'col-sm-6'));
                ?>
                <div class="col-sm-5">
                    <?php
                    echo $form->select('global_params[accordion_default_open]', array(0 => t('Closed'), 1 => t('Open')), $global_params['accordion_default_open']);
                    ?>
                </div>
                <div class="clearfix"></div>
                <?php
                /*
                 * When in accordion mode, ensure that one tab is always open, so that a 
                 * tab can't close itself. If you set this true, you will need to develop 
                 * appropriate custom templates with appropriate accordion css.
                 */
                echo $form->label('global_params[accordion_always_open]', t('Accordion always open:'), array('class' => 'col-sm-6'));
                ?>
                <div class="col-sm-5">
                    <?php
                    echo $form->select('global_params[accordion_always_open]', array(0 => t('May be fully closed'), 1 => t('Always one section open')), $global_params['accordion_always_open']);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="alert alert-info">
                <?php
                /*
                 * /concrete/src/Page/Theme/GridFramework/Type/Bootstrap3.php
                 * /concrete/src/Page/Theme/GridFramework/Type/Foundation.php
                 * /concrete/src/Page/Theme/GridFramework/Type/NineSixty.php
                 * 
                 * used by (for example)
                 * /concrete/elements/block_header_view.php
                 */
                $page = Page::getCurrentPage();
                if (method_exists($page, 'getCollectionThemeObject')) {
                    $pt = $page->getCollectionThemeObject();
                    if (is_object($pt) && method_exists($pt, 'getThemeGridFrameworkObject')) {
                        $gf = $pt->getThemeGridFrameworkObject();
                        if (is_object($gf) && method_exists($gf, 'getPageThemeGridFrameworkContainerStartHTML')) {
                            $theme_base = $gf->getPageThemeGridFrameworkName();
                            $grid_container = $gf->getPageThemeGridFrameworkContainerStartHTML();
                            $row_container = $gf->getPageThemeGridFrameworkRowStartHTML();
                        }
                    }
                }

                echo t('The next settings govern how theme grid elements are processed when rendering Magic Tabs. You may need to experiment with these settings if tabs (and particularly vertical tabs or accordions) are not laying out cleanly. The default settings are "Preserve", "container" and "Do not Wrap". The most likely alternative is to set both "Remove" and "Wrap".');
                if ($theme_base) {
                    echo '<br>';
                    echo t('The current theme is uses %s and implements container \'%s\' and row \'%s\'.', h($theme_base), h($grid_container), h($row_container));
                }
                ?>
            </div>
            <div class="form-horizontal">
                <?php
                /*
                 * Preserve the grid box model. If set false, MT wrapped blocks are climbed out of
                 * levels of wrapping dom boxes. (default true)
                 */
                echo $form->label('global_params[preserve_grid_box]', t('Preserve any theme grid box about individual tab elements:'), array('class' => 'col-sm-6'));
                ?>
                <div class="col-sm-5">
                    <?php
                    echo $form->select('global_params[preserve_grid_box]', array(0 => t('Remove'), 1 => t('Preserve')), $global_params['preserve_grid_box']);
                    ?>
                </div>
                <div class="clearfix"></div>


                <?php
                /*
                 * Classes to be removed from grid elements
                 */
                echo $form->label('global_params[grid_classes_to_remove]', t('Classes that will be removed from elements contained within tabs:'), array('class' => 'col-sm-6'));
                ?>
                <div class="col-sm-5">
                    <?php
                    echo $form->text('global_params[grid_classes_to_remove]', $global_params['grid_classes_to_remove'], array('maxlength' => 255));
                    ?>
                </div>
                <div class="clearfix"></div>


                <?php
                /*
                 * Whether to wrap the entire tabset structure in a theme grid box. (default false)
                 */
                echo $form->label('global_params[wrap_with_grid_box]', t('Wrap entire tab set in any theme grid box:'), array('class' => 'col-sm-6'));
                ?>
                <div class="col-sm-5">
                    <?php
                    echo $form->select('global_params[wrap_with_grid_box]', array(0 => t('Do not wrap'), 1 => t('Wrap')), $global_params['wrap_with_grid_box']);
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group clearfix">
            <div class="alert alert-info">
                <?php
                echo t('Animated transitions between tabs can be disabled on mobile devices.');
                ?>
            </div>
            <div class="form-horizontal">
                <?php
                /*
                 * Animated transitions between tabs can be disabled on mobile devices. mobile_no_transitions defaults to false.
                 */
                echo $form->label('global_params[mobile_no_transitions]', t('Show transitions on mobile devices:'), array('class' => 'col-sm-6'));
                ?>
                <div class="col-sm-5">
                    <?php
                    echo $form->select('global_params[mobile_no_transitions]', array(0 => t('Transitions on mobile'), 1 => t('No Transitions on mobile')), $global_params['mobile_no_transitions']);
                    ?>
                </div>

            </div>
        </div>        

        <div class="form-group clearfix">
            <div class="alert alert-info">
                <?php
                echo t('Control how magic tabs treats elements hidden by the block or area design. When enabled, elements in a tab set hidden by "display:none" in block design or the class "magic-tabs-hide" in block or area desaign will be shown when the tab set is rendered. This can be used in association with block or area design to hide a flash of un-styled content and defaults to true. Please refer to the magic tabs documentation for detailed explanation.');
                ?>
            </div>
            <div class="form-horizontal">
                <?php
                /*
                 * Auto Show, shoiw blocks hidden by block design
                 */
                echo $form->label('global_params[auto_show]', t('Show blocks hidden by block design:'), array('class' => 'col-sm-6'));
                ?>
                <div class="col-sm-5">
                    <?php
                    echo $form->select('global_params[auto_show]', array(0 => t('Leave unchanged'), 1 => t('Show hidden blocks')), $global_params['auto_show']);
                    ?>
                </div>

            </div>
        </div>                
    </div>
    <div id="ccm-tab-content-help" class="ccm-tab-content">
        <p>
            <?php
            $c5magic_mt_url = "http://www.c5magic.co.uk/add-ons/magic-tabs/getting-started/";
            echo t('Documentation and advice for Magic Tabs can be found at <a href="%s" target="_blank">%s</a>', $c5magic_mt_url, $c5magic_mt_url);
            ?>
        </p>
        <p>
            <?php
            if ($ch->is_57()) {
                $support_url = "http://www.concrete5.org/marketplace/addons/magic-tabs1/support/";
                echo t('Support requests for Magic Tabs on concrete 5.7+ can be found at <a href="%s" target="_blank">%s</a>', $support_url, $support_url);
            } else {
                $support_url = "http://www.concrete5.org/marketplace/addons/magic-tabs/support/";
                echo t('Support requests for Magic Tabs up to concrete 5.6.x can be found at <a href="%s" target="_blank">%s</a>', $support_url, $support_url);
            }
            ?>
        </p>
    </div>

    <div style="clear:both;"></div>

</div>
