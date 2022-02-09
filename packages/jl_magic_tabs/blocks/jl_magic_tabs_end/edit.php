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
?>
<div class="jl-magic-tabs-end-edit  ccm-ui">
    <div class="alert alert-info">
        <p>
            <?php
            echo t('Optionally end a set of magic tabs before the end of a page area. If you are breaking an entire area into tabs, you do not need to use this block.');
            ?>
        </p>
        <p>
            <?php
            echo t('After ending a set of magic tabs, any remaining content will be shown below the tabbed part of the area. You can also start a new set of magic tabs within the same area.');
            ?>
        </p>
    </div>

    <div>
        <?php
        echo $form->label('level', t('Optional nesting level to end:'));
        if (empty($level)) {
            $level = 0;
        }
        echo $form->select('level', $controller->get_nesting_level_options(), $level);
        ?>
    </div>
</div>