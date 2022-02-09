<?php
/**
 * @author      shahroq <shahroq \at\ yahoo.com>
 * @copyright   Copyright (c) 2017 shahroq.
 * http://concrete5.killerwhalesoft.com/addons/
 */
defined('C5_EXECUTE') or die("Access Denied.");

// Helpers
//$ih = Loader::helper('concrete/interface');
$fh = Loader::helper('form');
$ch = Loader::helper('form/color');
$al = Loader::helper('concrete/asset_library');
//dd($record);
?>

<?php  if ($this->controller->getTask() == 'update' || $this->controller->getTask() == 'edit' || $this->controller->getTask() == 'add') { ?>
<!--BEGIN: Add/Edit Form-->

    <?php
    //print_r($record->itemsObj);die;
    $task = 'add';
    $buttonText = t('Add Parallax Area');
    $buttonText2 = '';
    if ($this->controller->getTask() != 'add') {
        $task = 'update';
        $buttonText = t('Update Parallax Area');
        $buttonText2 = t('Update Parallax Area & Stay');
    }
    ?>

<?php if(Config::get('whale_parallax_area.notice_form')){ ?>
<div class="alert alert-info" role="alert"><?php echo Config::get('whale_parallax_area.notice_form')?></div>
<?php } ?>

<!--Begin:form:-->
<form method="post" action="<?php  echo $this->action($task)?>" id="form" class="form-horizontal" role="form">
<div class="ccm-pane-body" id="whale-form">

    <?php
    if ($this->controller->getTask() != 'add') {
        echo $fh->hidden('id', $record->id);
    }
    ?>

<!-- Begin: Tabs -->
<!--<p>-->
<?php
    print Loader::helper('concrete/ui')->tabs(array(
        array('options', t('Options'), TRUE)
    ));
?>
<!--</p>-->
<!-- End: Tabs -->

<div style="height:20px;"></div>

<!-- Begin: Options Tab -->
<div class="ccm-tab-content" id="ccm-tab-content-options" >
<div class="well">
    <h2>
        <?php echo t('Options') ?>&nbsp;
        <a href="#form_options" class="show-hide pull-right" title="<?php  echo t('Click to Show/Hide')?>"><i class="fa fa-chevron-up"></i></a>
    </h2>
    <div id="form_options">
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php echo t('Background Image') ?>
            </label>
            <div class="col-xs-5">
                <?php
                $fld = 'fID';
                $fldObj = 'fObj';
                $ini_value = $record->{$fldObj};
                echo $al->image($fld, $fld, t('Choose Background Image'), $ini_value);
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php echo t('Bg Color') ?>
                <p class="text-muted"><?php echo t('Area background color') ?></p>
            </label>
            <div class="col-xs-2">
                <?php
                $fld = 'bgColor';
                $ini_value = $record->optionsObj->{$fld};
                echo $ch->output($fld, $ini_value, array('preferredFormat'=>'hex'))
                ?>
            </div>
            <div class="col-xs-5">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php echo t('BG Position') ?>
                <p class="text-muted"><?php echo t('Background Position: X & Y') ?></p>
            </label>
            <div class="col-xs-3">
                <?php
                $fld = 'bgPositionX';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo '<span class="input-group-addon">'.t('X').'</span>';
                echo $fh->text($fld, $ini_value, array('maxlength' => '3', 'placeholder' => '', 'class' => 'input-mini'));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>

                <?php
                $fld = 'bgPositionY';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo '<span class="input-group-addon">'.t('Y').'</span>';
                echo $fh->text($fld, $ini_value, array('maxlength' => '3', 'placeholder' => '', 'class' => 'input-mini'));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-4">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php echo t('Padding') ?>
                <p class="text-muted">
                    <?php echo t('Use Padding Top/Bottom to achieve area height') ?>
                    <br>
                    <?php echo t('Top:Right:Bottom:Left') ?>
                </p>
            </label>
            <div class="col-xs-5">
                <?php
                echo '<div class="input-group" style="margin-top:5px;">';
                $fld = 'paddingTop';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => '', 'style' => ''));
                echo '<span class="input-group-addon" style="min-width:0px;">:</span>';
                $fld = 'paddingRight';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => '', 'style' => ''));
                echo '<span class="input-group-addon" style="min-width:0px;">:</span>';
                $fld = 'paddingBottom';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => '', 'style' => ''));
                echo '<span class="input-group-addon" style="min-width:0px;">:</span>';
                $fld = 'paddingLeft';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => '', 'style' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php echo t('Padding (Mobile)') ?>
                <p class="text-muted">
                    <?php echo t('Use Padding Top/Bottom to achieve area height') ?>
                    <br>
                    <?php echo t('Top:Right:Bottom:Left') ?>
                </p>
            </label>
            <div class="col-xs-5">
                <?php
                echo '<div class="input-group" style="margin-top:5px;">';
                $fld = 'paddingTopMob';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => '', 'style' => ''));
                echo '<span class="input-group-addon" style="min-width:0px;">:</span>';
                $fld = 'paddingRightMob';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => '', 'style' => ''));
                echo '<span class="input-group-addon" style="min-width:0px;">:</span>';
                $fld = 'paddingBottomMob';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => '', 'style' => ''));
                echo '<span class="input-group-addon" style="min-width:0px;">:</span>';
                $fld = 'paddingLeftMob';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => '', 'style' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php echo t('Background Repeat') ?>
            </label>
            <div class="col-xs-3">
                <?php
                $fld = 'bgRepeat';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->select($fld, $bgRepeats, $ini_value, array('style' => ''));
                ?>
            </div>
            <div class="col-xs-4">&nbsp;</div>
        </div>
        <?php if(0==1){ ?>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php echo t('Background Size') ?>
            </label>
            <div class="col-xs-3">
                <?php
                $fld = 'bgSize';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->select($fld, $bgSizes, $ini_value, array('style' => ''));
                ?>
            </div>
            <div class="col-xs-4">&nbsp;</div>
        </div>
        <?php } ?>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php echo t('Factor') ?>
                <p class="text-muted">
                    <?php echo t('It sets elements offset and speed. It can be positive (0.5) or negative (-0.5). Less means slower.') ?>
                </p>
            </label>
            <div class="col-xs-3">
                <?php
                $fld = 'factor';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '4', 'style' => ''));
                ?>
            </div>
            <div class="col-xs-4">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php echo t('Type') ?>
            </label>
            <div class="col-xs-3">
                <?php
                $fld = 'type';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->select($fld, $types, $ini_value, array('style' => ''));
                ?>
            </div>
            <div class="col-xs-4">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php echo t('Direction') ?>
            </label>
            <div class="col-xs-3">
                <?php
                $fld = 'direction';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->select($fld, $directions, $ini_value, array('style' => ''));
                ?>
            </div>
            <div class="col-xs-4">&nbsp;</div>
        </div>

    </div>
</div>
</div>
<!-- End: Options Tab -->

<!-- Begin: Buttons -->
        <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <a href="<?php echo URL::page($c)?>" class="btn btn-default pull-left"><?php echo t('Back')?></a>
            <?php echo $fh->submit('ccm-update', $buttonText, array('class'=>'btn btn-primary pull-right')); ?>
            <?php if($task=='update') echo $fh->submit('ccm-update2', $buttonText2, array('class'=>'btn btn-primary pull-right', 'style'=>'margin-right:5px;')); ?>
        </div>
        </div>
<!-- END: Buttons -->

</div>
</form>

<!--END: Add/Edit Form-->
<?php  }else{ ?>
<!--BEGIN: GRID-->

<?php if(Config::get('whale_parallax_area.notice_list')){ ?>
<div class="alert alert-info" role="alert"><?php echo Config::get('whale_parallax_area.notice_list')?></div>
<?php } ?>

<div class="ccm-dashboard-content-full">

    <div class="ccm-dashboard-header-buttons">
        <a class="btn btn-primary" href="<?php  echo $this->action('add')?>">
            <i title="Add" class="fa fa-plus-circle"></i>
            <?php  echo t('Add New Parallax Area');?>
        </a>
    </div>

    <div data-search-element="wrapper">
        <form role="form" data-search-form="wps-carousel" action="<?php echo $controller->action('view')?>" class="form-inline ccm-search-fields">
            <div class="ccm-search-fields-row">
                 <div class="form-group" style="width:97%;">
                        <?php echo $fh->label('fKeywords', t('Search'))?>
                        <div class="ccm-search-field-content">
                            <div class="ccm-search-main-lookup-field">
                                <i class="fa fa-search"></i>
                                <?php echo $fh->search('fKeywords', array('placeholder' => t('Keywords')))?>
                                <button type="submit" class="ccm-search-field-hidden-submit" tabindex="-1"><?php echo t('Search')?></button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info pull-right"><?php echo t('Search')?></button>
                    </div>
                </div>
            <div class="ccm-search-fields-submit">

            </div>
        </form>
    </div>

    <form method="post" action="<?php  echo $this->action('mass_update')?>" id="mass-update-form">
    <div data-search-element="results">
        <div class="table-responsive">


        <?php if(count($list) > 0) { ?>
            <table class="ccm-search-results-table whale-table">
                <thead>
                <tr>
                    <th><span><input id="ccm-list-cb-all" type="checkbox" data-search-checkbox="select-all"></span></th>
                    <th><span><?php echo t('ID')?></span></th>
                    <?php
                    $poTitle = t('Using this class');
                    $poDesc = t('This generated class can be used for any area/block wrapper on your active theme. Right click on any block, select Design, and at CSS tab, insert it at CSS Class Name(s).');
                    ?>
                    <th><span>
                        <?php echo t('Class')?>
                        
                        <a href="#" data-toggle="popover" data-content="<?php echo $poDesc?>" data-original-title="<?php echo $poTitle?>">
                            <i class="fa fa-question-circle"></i>
                        </a>

                    </span></th>
                    <th><span><?php echo t('Operations')?></span></th>
                </tr>
                </thead>
                <tbody>
                <?php  foreach((array)$list as $item){ ?>
                <tr>
                    <td class="ccm-list-cb" style="vertical-align: middle !important"><input name="cb_items[]" type="checkbox" value="<?php echo $item['id']?>" data-search-checkbox="individual"/></td>
                    <td><?php echo $item['id'] ?></td>
                    <td><span class="label label-default"><?php echo 'wpa-'.$item['id'] ?></span>&nbsp;</td>
                    <td>
                        <a href="<?php  echo $this->action('edit/'.$item['id'])?>" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                            <?php  echo t("Edit")?>
                        </a>
                    </td>
                </tr>
                <?php  } ?>
                </tbody>
            </table>
        <?php }else{ ?>
            <div class="ccm-search-fields-row" style="font-weight: bold;">
            <?php  echo t('No record found.') ?>
            </div>
        <?php } ?>

        </div>
    </div>

    <?php echo (isset($l))?$l->displayPagingV2():''?>

    <?php if(count($list) > 0) {?>
    <!-- Begin: Buttons -->
        <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <?php //echo $fh->submit('ccm-delete', t('Delete'), array('style' => '', 'class'=>'btn btn-danger pull-right', 'onclick'=>'return confirm_delete()')); ?>
            <?php
            echo $fh->submit('ccm-mass-update', t('Delete'), array('style' => 'margin-right:5px;', 'class'=>'btn btn-danger pull-right', 'onclick'=>'return confirm_delete()'));
            echo $fh->submit('ccm-mass-update', t('Duplicate'), array('style' => 'margin-right:5px;', 'class'=>'btn btn-primary pull-right', 'onclick'=>''));
            ?>
        </div>
        </div>
    <!-- : Buttons -->
    <?php } ?>

    </form>
</div>

<!--END: GRID-->
<?php  } ?>

<script type="text/javascript">
$(document).ready(function () {
});
//delete confirmation
function confirm_delete(){
    msg = "<?php echo t('Are you sure?') ?>";
    return confirm(msg);
}
</script>
