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
$cycle_actions = array(
    'next_cycle' => t('Next & Cycle'),
    'next' => t('Next'),
    'prev_cycle' => t('Previous & Cycle'),
    'prev' => t('Previous'),
);
?>
<div class="jl-magic-tabs-jump-edit ccm-ui" data-jump-actions="<?php echo addslashes($jump_actions_json); ?>">

    <div class="row">
        <div class="col-sm-6 form-group">
            <?php
            if (empty($play_label)) {
                $play_label = '';
            }
            echo $form->label('play_label', t('Label for Play button (optional)'));
            echo $form->text('play_label', $play_label, array('maxlength' => 20));
            ?>
        </div>

        <div class="col-sm-6 form-group">
            <?php
            if (empty($pause_label)) {
                $pause_label = '';
            }
            echo $form->label('pause_label', t('Label for Pause button (optional)'));
            echo $form->text('pause_label', $pause_label, array('maxlength' => 20));
            ?>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-6 form-group">
            <?php
            echo $form->label('play_options[]', t('Play starts/resumes on:'));
            ?>
            <div class="checkbox">
                <?php
                foreach ($controller->get_play_options_list() as $oh => $otxt) {
                    ?>
                    <label for="play_options">
                        <?php
                        echo $form->checkbox('play_options[]', $oh, in_array($oh, $play_options));
                        echo '&nbsp;';
                        echo $otxt;
                        ?>
                    </label>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="col-sm-6 form-group">
            <?php
            echo $form->label('pause_options[]', t('Play pauses/stops on:'));
            ?>
            <div class="checkbox">
                <?php
                foreach ($controller->get_pause_options_list() as $oh => $otxt) {
                    ?>
                    <label for="pause_options">
                        <?php
                        echo $form->checkbox('pause_options[]', $oh, in_array($oh, $pause_options));
                        echo '&nbsp;';
                        echo $otxt;
                        ?>
                    </label>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>


    <div class="clearfix form-group">

        <?php
        /*
          A split scale slider, as per my howto, but 10x the range, so 300ms to 10,000ms
          http://www.concrete5.org/documentation/how-tos/developers/add-a-slider-control-to-an-edit-menu-or-form/
          http://www.concrete5.org/documentation/how-tos/developers/create-a-split-scale-slider-for-greater-range./
          http://getbootstrap.com/2.3.2/components.html#labels-badges
         */
        ?>
        <label for="cycle_interval">
            <?php
            echo t('Time interval between tabs:');
            ?>
            <span class="cycle_interval_slider_value label label-default" >
                <?php
                if (empty($cycle_interval)) {
                    $cycle_interval = 1000;
                }
                echo $cycle_interval / 1000;
                ?>
            </span>
            <span class="cycle_interval_units">
                <?php
                echo ' ';
                echo t('seconds');
                ?>
            </span>
        </label>

        <?php
        echo $form->text('cycle_interval', $cycle_interval, array('class' => 'cycle_interval_slider'));
        ?>

        <div class="cycle_interval_slider">
        </div>

    </div>

    <div class="clearfix row">
        <div class="col-sm-6 form-group">
            <?php
            if (empty($cycle_action)) {
                $cycle_action = 'next_cycle';
            }
            echo $form->label('cycle_action', t('Action for the player:'));
            echo $form->select('cycle_action', $cycle_actions, $cycle_action);
            ?>
        </div>

        <div class="col-sm-6 form-group">
            <?php
            echo $form->label('cycle_target', t('Target tab set:'), array('title' => t('Optional, see notes below.')));
            if (empty($level)) {
                $level = 0;
            }
            echo $form->text('cycle_target', $cycle_target);
            ?>
        </div>
    </div>

    <div class="clearfix alert alert-info">
        <?php
        echo t('If you only have one set of Magic Tabs on the page, you can usually leave the target tab set blank. To identify a tab set you can provide any of:');
        echo '<ul style="margin-bottom:0px;margin-top:0px;"><li>' . t('An #id for the tab set.') . '</li>';
        echo '<li>' . t('An #id for any tab in the set.') . '</li>';
        echo '<li>' . t('The label of any tab in the tab set.') . '</li></ul>';
        ?>
    </div>
</div>
<script>
    !function(e){e("input.cycle_interval_slider").hide(); var i = parseInt(e("input.cycle_interval_slider").val(), 10); i > 1e5?i = (i - 1e5) / 1e3 + 2900:i > 1e4?i = (i - 1e4) / 100 + 1900:i > 1e3 && (i = (i - 1e3) / 10 + 1e3); var l = function(i){i > 2900?i = 1e3 * (i - 2900) + 1e5:i > 1900?i = 100 * (i - 1900) + 1e4:i > 1e3 && (i = 10 * (i - 1e3) + 1e3), e("span.cycle_interval_slider_value").text(i / 1e3), e("input.cycle_interval_slider").val(i)}; e("div.cycle_interval_slider").slider({min:300, step:10, max:4600, value:i, slide:function(e, i){l(i.value)}}).trigger("slide")}(jQuery);
</script>