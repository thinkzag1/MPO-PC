<?php

namespace Concrete\Package\JlMagicTabs\Src\Helpers;

use Core;
use Config;

defined('C5_EXECUTE') or die("Access Denied.");

/**
 * Magic Tabs -  by John Liddiard (aka JohntheFish)
 * www.jlunderwater.co.uk, www.c5magic.co.uk
 * This software is licensed under the terms described in the concrete5.org marketplace.
 * Please find the add-on there for the latest license copy.
 */
class JlShowHide
{
    public function edit_control($options)
    {

        $transition_speed = $options['duration'];
        $transition_speed_key = $options['duration_key'];

        $transition_type = $options['transition'];
        $transition_type_key = $options['transition_key'];

        $transition_direction = $options['direction'];
        $transition_direction_key = $options['direction_key'];

        $transition_easing = $options['easing'];
        $transition_easing_key = $options['easing_key'];

        $transition_adaptive_dir = $options['adaptive_dir'];
        $transition_adaptive_dir_key = $options['adaptive_dir_key'];

        $form = Core::make('helper/form');

        ob_start();
        ?>

        <div class="form-group clearfix transition_options">

            <?php
            if (!empty($transition_type_key)) {
                ?>
                <div class="form-horizontal clearfix  <?php echo $transition_type_key; ?>" title="<?php echo t('Transition methods only apply when there is a transition speed. Not all options of direction and easing are relevant to the various types of transition.'); ?>">
                    <?php
                    echo $form->label('transition_type', t('Type of transition'), array('class' => 'col-sm-6'));
                    ?>
                    <div class="col-sm-5">
                        <?php
                        echo $form->select($transition_type_key, $this->transition_options(), $transition_type);
                        ?>
                    </div>
                </div>
                <?php
            }

            if (!empty($transition_direction_key)) {
                ?>
                <div class="form-horizontal clearfix <?php echo $transition_direction_key; ?>" title="<?php echo t('Direction of transition. Where two directions are given, the first is for the out or hide transition. The second is for the in or show transition. Not all transition types support a direction.'); ?>">
                    <?php
                    echo $form->label('transition_direction', t('Direction'), array('class' => 'col-sm-6'));
                    ?>
                    <div class="col-sm-5">
                        <?php
                        echo $form->select($transition_direction_key, $this->direction_options(), $transition_direction);
                        ?>
                    </div>
                </div>
                <?php
            }


            if (!empty($transition_adaptive_dir_key)) {
                ?>
                <div class="form-horizontal clearfix <?php echo $transition_adaptive_dir_key; ?>" title="<?php echo t('Adapt direction to the relationship between the items to show and hide. For example, in a list, swap the direction when the list is descending.'); ?>">
                    <?php
                    echo $form->label('transition_adaptive_dir', t('Adapt Direction'), array('class' => 'col-sm-6'));
                    ?>
                    <div class="col-sm-5">
                        <?php
                        $adapt_options = array('Y' => t('Enabled'), 'N' => t('Disabled'));
                        if (empty($transition_adaptive_dir)) {
                            $transition_adaptive_dir = 'Y';
                        }
                        echo $form->select($transition_adaptive_dir_key, $adapt_options, $transition_adaptive_dir);
                        ?>
                    </div>
                </div>
                <?php
            }

            if (!empty($transition_easing_key)) {
                ?>
                <div class="form-horizontal clearfix <?php echo $transition_easing_key; ?>" title="<?php echo t('Easing governs the mapping of transitions, linear or various curves. \'Context\' switches between Out and In methods. Not all transition types support easing methods.'); ?>">
                    <?php
                    echo $form->label('transition_easing_key', t('Easing method'), array('class' => 'col-sm-6'));
                    ?>
                    <div class="col-sm-5">
                        <?php
                        echo $form->select($transition_easing_key, $this->easing_options(), $transition_easing);
                        ?>
                    </div>
                </div>
                <?php
            }


            if (!empty($transition_speed_key)) {
                // slider for transition_speed
                $tip2 = t('The speed of transition in milliseconds. Note that total time will be 2 x the slider value because there is a transition out followed by a transition in.');
                ?>
                <div id="<?php echo $transition_speed_key; ?>_slider" class="jl_show_hide_helper_slider" style="clear:both" title="<?php echo $tip2; ?>">
                    <label for="<?php echo $transition_speed_key; ?>">
                        <?php
                        echo t('Transition speed:');
                        ?>
                        <span class="jl_show_hide_helper_slider_inner">
                            <?php
                            echo (integer) $transition_speed;
                            ?>
                        </span> <?php echo t('ms'); ?>.
                    </label>
                    <div style="clear:both"></div>
                    <?php
                    echo $form->text($transition_speed_key, (integer) $transition_speed, array('class' => 'jl_show_hide_helper_slider_inner'));
                    ?>
                    <div 	class="jl_show_hide_helper_slider_inner"
                          data-range-min="0"
                          data-range-max="5000"
                          data-range-step="10"
                          style="margin-top:5px;margin-bottom:5px;margin-left:10px;margin-right:10px">
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        echo $this->s_h_edit_script($transition_speed_key . '_slider');

        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    /*
      transitions
     */
    public function transition_options()
    {
        return array(
            'fade' => t('Fade in/out'),
            'show' => t('Show/hide'),
            'slide' => t('Slide up/down'),
            /*
              https://jqueryui.com/hide/
              http://api.jqueryui.com/category/effects/
             */
            'ui-slide' => t('Slide (ui)'),
            'ui-blind' => t('Blind'),
            'ui-bounce' => t('Bounce'),
            'ui-clip' => t('Clip'),
            'ui-drop' => t('Drop'),
            'ui-explode' => t('Explode'),
            'ui-fade' => t('Fade (ui)'),
            'ui-fold' => t('Fold'),
            'ui-highlight' => t('Highlight'),
            'ui-puff' => t('Puff'),
            'ui-pulsate' => t('Pulsate'),
            'ui-scale' => t('Scale'),
            'ui-shake' => t('Shake'),
            'ui-size' => t('Size'),
        );
    }

    public function direction_options()
    {
        return array(
            'lr' => t('Left/Right'),
            'rl' => t('Right/Left'),
            'll' => t('Left'),
            'rr' => t('Right'),
            'ud' => t('Up/Down'),
            'du' => t('Down/Up'),
            'uu' => t('Up'),
            'dd' => t('Down'),
            'bb' => t('Horizontal and Vertical'),
            'hh' => t('Horizontal'),
            'vv' => t('Vertical'),
        );
    }

    /*
      easing
      http://gsgd.co.uk/sandbox/jquery/easing/
      http://easings.net/
     */
    public function easing_options()
    {
        return array(
            'linear' => t('Linear'),
            'swing' => t('Swing'),
            'jswing' => t('Jswing'),
            'easeInQuad' => t('InQuad'),
            'easeOutQuad' => t('OutQuad'),
            'easeInOutQuad' => t('InOutQuad'),
            'easeContextQuad' => t('ContextQuad'),
            'easeInCubic' => t('InCubic'),
            'easeOutCubic' => t('OutCubic'),
            'easeInOutCubic' => t('InOutCubic'),
            'easeContextCubic' => t('ContextCubic'),
            'easeInQuart' => t('InQuart'),
            'easeOutQuart' => t('OutQuart'),
            'easeInOutQuart' => t('InOutQuart'),
            'easeContextQuart' => t('ContextQuart'),
            'easeInQuint' => t('InQuint'),
            'easeOutQuint' => t('OutQuint'),
            'easeInOutQuint' => t('InOutQuint'),
            'easeContextQuint' => t('ContextQuint'),
            'easeInSine' => t('InSine'),
            'easeOutSine' => t('OutSine'),
            'easeInOutSine' => t('InOutSine'),
            'easeContextSine' => t('ContextSine'),
            'easeInExpo' => t('InExpo'),
            'easeOutExpo' => t('OutExpo'),
            'easeInOutExpo' => t('InOutExpo'),
            'easeContextExpo' => t('ContextExpo'),
            'easeInCirc' => t('InCirc'),
            'easeOutCirc' => t('OutCirc'),
            'easeInOutCirc' => t('InOutCirc'),
            'easeContextCirc' => t('ContextCirc'),
            'easeInElastic' => t('InElastic'),
            'easeOutElastic' => t('OutElastic'),
            'easeInOutElastic' => t('InOutElastic'),
            'easeContextElastic' => t('ContextElastic'),
            'easeInBack' => t('InBack'),
            'easeOutBack' => t('OutBack'),
            'easeInOutBack' => t('InOutBack'),
            'easeContextBack' => t('ContextBack'),
            'easeInBounce' => t('InBounce'),
            'easeOutBounce' => t('OutBounce'),
            'easeInOutBounce' => t('InOutBounce'),
            'easeContextBounce' => t('ContextBounce'),
        );
    }

    private function s_h_edit_script($slider_key)
    {
        ob_start();
        ?>
        <script type="text/javascript">
            (function(){var e = $("#<?php echo $slider_key; ?>"); var t = $(e).find("div.jl_show_hide_helper_slider_inner"); var n = $(e).find("input.jl_show_hide_helper_slider_inner"); var r = $(e).find("span.jl_show_hide_helper_slider_inner"); var i = parseInt($(t).attr("data-range-min"), 10); var s = parseInt($(t).attr("data-range-max"), 10); var o = parseInt($(t).attr("data-range-step"), 10); $(n).hide(); var u = parseInt($(n).val(), 10); $(r).text(u); $(t).slider({min:i, step:o, max:s, value:u, slide:function(e, t){var i = t.value; $(r).text(i); $(n).val(i)}})})()
        </script>
        <?php
        $script = ob_get_contents();
        ob_end_clean();
        return $script;
    }

    public function required_assets($block, $options)
    {

        $transition_speed = $options['duration'];
        $transition_type = $options['transition'];
        $transition_direction = $options['direction'];
        $transition_easing = $options['easing'];

        $html = Core::make('helper/html');

        if (preg_match("/^ease/", $transition_easing)) {
            /*
              http://gsgd.co.uk/sandbox/jquery/easing/
             */
            $block->requireAsset('javascript', 'easing');
        }

        /*
          Make sure we have ui for some transitions
         */
        if (preg_match("/^ui-/", $transition_type)) {
            $block->requireAsset('css', 'jquery/ui');
            $block->requireAsset('javascript', 'jquery/ui');

            /*
              Maybe smooth animations
              https://github.com/gnarf/jquery-requestAnimationFrame
             */
            $block->requireAsset('javascript', 'animate/enhanced');
            $block->requireAsset('javascript', 'animation/frame');
        }



        /*
          Make sure we have transition helper suppoort for some transitions
         */
        if (!empty($transition_speed)) {
            $block->requireAsset('javascript', 'magicTabs/show-hide');

            if ($this->is_57() && Config::get('app.magic_tabs.bad_ie_v')) {
                $bad_iev = (int) Config::get('app.magic_tabs.heading_levels');
            } else if (defined('JL_MAGIC_TABS_BAD_IE_V')) {
                $bad_iev = (int) 'JL_MAGIC_TABS_BAD_IE_V';
            }

            if (empty($bad_iev)) {
                $bad_iev = 8;
            }


            // insert a div as a marker for old ie versions
            $sfiev = Config::get('app.magic_tabs.bad_ie_v');
            if (!empty($sfiev)) {
                $bad_iev = (int) $sfiev;
            }
            $block->addFooterItem('<!--[if lte IE <?php echo $bad_iev;?> ]><div class="bad-ie"></div><![endif]-->');

            // insert a div as a marker for mobile devices
            $md = new \Mobile_Detect();
            if ($md->isMobile()) {
                $block->addFooterItem('<div class="notify-is-mobile"></div>');
            }
        }
    }

    public function is_57()
    {
        /*
          Should respond to core versions less than 5.7
         */
        if (defined('APP_VERSION') && version_compare(APP_VERSION, '5.7', 'lt')) {
            return false;
        }
        /*
          Probably a redundant test, but just to be safe as these are the operations
          we are using it for
         */
        return class_exists('Config') && method_exists('Config', 'get');
    }

}
