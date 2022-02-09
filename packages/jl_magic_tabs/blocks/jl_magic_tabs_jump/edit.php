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

$jump_actions = array(
    'prev' => t('Previous'),
    'next' => t('Next'),
    'prev_cycle' => t('Previous & Cycle'),
    'next_cycle' => t('Next & Cycle'),
    'first' => t('First'),
    'last' => t('Last'),
    'goto' => t('GoTo'),
);

$jh = Core::make('helper/json');
$jump_actions_json = $jh->encode($jump_actions);
?>
<div class="jl-magic-tabs-jump-edit ccm-ui" data-jump-actions="<?php echo addslashes($jump_actions_json); ?>">
    <div>


        <div class="form-group clearfix" >
            <div class="form-horizontal">
                <?php
                echo $form->label('jump_action', t('Action for the button:'), array('class' => 'col-sm-6'));
                ?>
                <div class="col-sm-5">
                    <?php
                    if (empty($jump_action)) {
                        $jump_action = 'next';
                    }
                    if (empty($jump_label)) {
                        $jump_label = $jump_actions[$jump_action];
                    }
                    echo $form->select('jump_action', $jump_actions, $jump_action);
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group clearfix" >
            <div class="form-horizontal">
                <?php
                echo $form->label('jump_label', t('Label for the button:'), array('class' => 'col-sm-6', 'title' => t('You can edit the automatically set label to whatever you like.')));
                ?>
                <div class="col-sm-5">
                    <?php
                    echo $form->text('jump_label', $jump_label);
                    echo $form->button('set_default', t('Default Label'), array('title' => t('Restore the label for this action to the default \'%s\'', $jump_actions[$jump_action])));
                    ?>
                </div>
            </div>
        </div>


        <div class="form-group clearfix" >
            <div class="form-horizontal">
                <?php
                echo $form->label('jump_target', t('Target tab or tab set:'), array('class' => 'col-sm-6', 'title' => t('Optional, see notes below.')));
                ?>
                <div class="col-sm-5">
                    <?php
                    echo $form->text('jump_target', $jump_target);
                    ?>
                </div>
            </div>
        </div>
        <div class="alert alert-info clearfix">
            <?php
            echo t('GoTo a tab requires a target. For other actions, if you only have one set of Magic Tabs on the page, you can usually leave the target blank.');
            echo '<br>';
            echo t('To identify a specific tab you can provide any of:');
            echo '<ul style="margin-bottom:0px;margin-top:0px;"><li>' . t('An #id for the tab.') . '</li>';
            echo '<li>' . t('The label of the tab.') . '</li></ul>';
            echo t('To identify a tab set you can provide any of:');
            echo '<ul style="margin-bottom:0px;margin-top:0px;"><li>' . t('An #id for the tab set.') . '</li>';
            echo '<li>' . t('An #id for any tab in the set.') . '</li>';
            echo '<li>' . t('The label of any tab in the tab set.') . '</li></ul>';
            ?>
        </div>
    </div>
</div>
<script>
    !function(a){var t = a.parseJSON("<?php echo addslashes($jump_actions_json); ?>"), e = "<?php echo $jump_action; ?>", i = "<?php echo $jump_label; ?>"; i != t[e]?a('.jl-magic-tabs-jump-edit input[name="set_default"]').show():a('.jl-magic-tabs-jump-edit input[name="set_default"]').hide(), a('.jl-magic-tabs-jump-edit select[name="jump_action"]').on("change", function(){a('.jl-magic-tabs-jump-edit input[name="set_default"]').hide(); var u = a(this).val(), m = a('.jl-magic-tabs-jump-edit input[name="jump_label"]').val(); u == e?(a('.jl-magic-tabs-jump-edit input[name="jump_label"]').val(i), m != t[e] && a('.jl-magic-tabs-jump-edit input[name="set_default"]').show()):a('.jl-magic-tabs-jump-edit input[name="jump_label"]').val(t[u])}), a('.jl-magic-tabs-jump-edit input[name="jump_label"]').on("keyup focusout mouseleave change", function(){var i = a(this).val(), u = a('.jl-magic-tabs-jump-edit select[name="jump_action"]').val(); return u != e?void a('.jl-magic-tabs-jump-edit input[name="set_default"]').hide():void(i == t[e]?a('.jl-magic-tabs-jump-edit input[name="set_default"]').hide():a('.jl-magic-tabs-jump-edit input[name="set_default"]').show())}), a('.jl-magic-tabs-jump-edit input[name="set_default"]').on("click", function(i){i.preventDefault(), i.stopPropagation(), a('.jl-magic-tabs-jump-edit input[name="jump_label"]').val(t[e]), a('.jl-magic-tabs-jump-edit input[name="set_default"]').hide()})}(jQuery);
</script>