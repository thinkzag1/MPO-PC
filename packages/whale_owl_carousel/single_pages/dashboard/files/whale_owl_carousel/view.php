<?php 
/**
 * @author      shahroq <shahroq \at\ yahoo.com>
 * @copyright   Copyright (c) 2016 shahroq
 * http://concrete5.killerwhalesoft.com/addons/
 */
defined('C5_EXECUTE') or die("Access Denied.");

// Helpers
//$ih = Loader::helper('concrete/interface');
$fh = Loader::helper('form');
$ch = Loader::helper('form/color');
//$al = Loader::helper('concrete/asset_library');
?>

<?php   if ($this->controller->getTask() == 'update' || $this->controller->getTask() == 'edit' || $this->controller->getTask() == 'add') { ?>
<!--BEGIN: Add/Edit Form-->

    <?php 
    //print_r($record->itemsObj);die;
    $task = 'add';
    $buttonText = t('Add Carousel');
    $buttonText2 = '';
    if ($this->controller->getTask() != 'add') {
        $task = 'update';
        $buttonText = t('Update Carousel');
        $buttonText2 = t('Update Carousel & Stay');
    }
    ?>

<?php  if(Config::get('whale_owl_carousel.notice_form')){ ?>
<div class="alert alert-info" role="alert"><?php  echo Config::get('whale_owl_carousel.notice_form')?></div>
<?php  } ?>

<!--Begin:form:-->
<form method="post" action="<?php   echo $this->action($task)?>" id="form" class="form-horizontal" role="form">
<div class="ccm-pane-body" id="whale-form">

    <?php 
    if ($this->controller->getTask() != 'add') {
        echo $fh->hidden('id', $record->id);
    }
    ?>

<!-- Begin: Tabs -->
<!--<p>-->
<?php 
    $fld = 'lightbox';
    $ini_value = $record->optionsObj->{$fld};

    print Loader::helper('concrete/ui')->tabs(array(
        //array('carousel', t('Carousel'), (($task=='add')?TRUE:FALSE)),
        array('carousel', t('Carousel'), (TRUE)),
        //array('slides', t('Slides'), (($task=='add')?FALSE:TRUE)),
        array('slides', t('Slides'), FALSE),
        array('lightbox', $fh->checkbox($fld, 1, $ini_value, array('target'=>'#ccm-tab-content-lightbox .well')).'&nbsp;'.t('Lightbox'), (FALSE))
    ));
?>
<!--</p>-->
<!-- End: Tabs -->

<div style="height:20px;"></div>

<!-- Begin: Carousel Tab -->
<DIV class="ccm-tab-content" id="ccm-tab-content-carousel" >
<div class="well">
    <h2>
        <?php  echo t('Carousel Options') ?>&nbsp;
        <a href="#form_carousel_options" class="show-hide pull-right" title="<?php   echo t('Click to Show/Hide')?>"><i class="fa fa-chevron-up"></i></a>
    </h2>
    <div id="form_carousel_options" style="display:non;">
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Carousel Name') ?>*
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'carouselName';
                $ini_value = $record->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '255', 'placeholder' => '', 'style' => ''));
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row" style="display:none;">
            <label class="col-xs-5 control-label">
                <?php   echo t('Plugin') ?>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'carouselPlugin';
                $ini_value = $record->{$fld};
                echo $fh->select($fld, $carouselPlugins, $ini_value, array('style' => ''));
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr style="display:none;"/>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Theme') ?>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'carouselTheme';
                $ini_value = $record->{$fld};
                echo $fh->select($fld, $carouselThemes, $ini_value, array('style' => ''));
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Show Title') ?>
                <p class="text-muted"><?php  echo t('Display Title at carousel.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'showTitle';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Show Description') ?>
                <p class="text-muted"><?php  echo t('Display Description at carousel.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'showDescription';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Show Extra Text') ?>
                <p class="text-muted"><?php  echo t('Display Extra Text at carousel.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'showExtraText';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Single Item') ?>
                <p class="text-muted">
                <?php  echo t('Display only one item.') ?>
                <br>
                <?php  echo t('Check this for creating SLIDERS.') ?>
                </p>
            </label>
            <div class="col-xs-2">
                <?php 
                $fld = 'singleItem';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array('target'=>'.single-item-related'));
                ?>
            </div>
            <div class="col-xs-5">&nbsp;</div>
        </div>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Full-Screen') ?>
                &nbsp;/&nbsp;
                <?php  echo t('Background Position') ?>
                <p class="text-muted">
                <?php  echo t('Display slider on full-screen mode.') ?>
                <br>
                <?php  echo t('Note that this option only available for Single Item mode. Also lightbox effect is not available in full-screen mode.') ?>
                </p>
            </label>
            <div class="col-xs-1">
                <?php 
                $fld = 'fullscreen';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">
                <?php 
                $fld = 'bgPosition';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '3', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">'.t('%').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-4">&nbsp;</div>
        </div>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Responsive Caption') ?>
                <p class="text-muted">
                <?php  echo t('Scale slider caption with window size') ?>
                <br>
                <?php  echo t('Works for single item (sliders)') ?>
                </p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'responsiveCaption';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row single-item-related">
            <label class="col-xs-5 control-label">
                <?php  echo t('Items') ?>
                <p class="text-muted"><?php  echo t('This variable allows you to set the maximum amount of items displayed at a time with the widest browser width') ?></p>
            </label>
            <div class="col-xs-2">
                <?php 
                $fld = 'itemsNum';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => '', 'class' => ''));
                ?>
            </div>
            <div class="col-xs-5">&nbsp;</div>
        </div>
        <hr>
        <div class="row single-item-related">
            <label class="col-xs-5 control-label">
                <?php  echo t('Items Desktop') ?>
                <p class="text-muted"><?php  echo t('This allows you to preset the number of slides visible with a particular browser width. The format is [x,y] whereby x=browser width and y=number of slides displayed. For example [1199,4] means that if(window<=1199){ show 4 slides per page} Alternatively use itemsDesktop: false (leave it blank) to override these settings.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                echo '<div class="input-group">';
                echo '<span class="input-group-addon">[</span>';

                $fld = 'itemsDesktopX';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '4', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">,</span>';
                $fld = 'itemsDesktopY';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '1', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">]</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row single-item-related">
            <label class="col-xs-5 control-label">
                <?php  echo t('Items Desktop Small') ?>
                <p class="text-muted"><?php  echo t('As above.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                echo '<div class="input-group">';
                echo '<span class="input-group-addon">[</span>';

                $fld = 'itemsDesktopSmallX';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '4', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">,</span>';
                $fld = 'itemsDesktopSmallY';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '1', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">]</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row single-item-related">
            <label class="col-xs-5 control-label">
                <?php  echo t('Items Tablet') ?>
                <p class="text-muted"><?php  echo t('As above.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                echo '<div class="input-group">';
                echo '<span class="input-group-addon">[</span>';

                $fld = 'itemsTabletX';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '4', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">,</span>';
                $fld = 'itemsTabletY';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '1', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">]</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row single-item-related">
            <label class="col-xs-5 control-label">
                <?php  echo t('Items Tablet Small') ?>
                <p class="text-muted"><?php  echo t('As above. Default value is disabled.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                echo '<div class="input-group">';
                echo '<span class="input-group-addon">[</span>';

                $fld = 'itemsTabletSmallX';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '4', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">,</span>';
                $fld = 'itemsTabletSmallY';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '1', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">]</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row single-item-related">
            <label class="col-xs-5 control-label">
                <?php  echo t('Items Mobile') ?>
                <p class="text-muted"><?php  echo t('As above.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                echo '<div class="input-group">';
                echo '<span class="input-group-addon">[</span>';

                $fld = 'itemsMobileX';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '4', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">,</span>';
                $fld = 'itemsMobileY';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '1', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">]</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Auto Play') ?>
                <p class="text-muted"><?php  echo t('Change to any integer for example autoPlay : 5000 to play every 5 seconds.') ?></p>
            </label>
            <div class="col-xs-3">
                <?php 
                $fld = 'autoPlay';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '5', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">'.t('ms').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-4">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Progress Bar') ?>
                <p class="text-muted">
                    <?php  echo t('Enable')." | ".t('Height')." | ".t('BG Color')." | ".t('Fill Color') ?>
                    <br>
                    <?php  echo t('Progress bar only displayed for Single Item carousels with AutoPlay on.') ?>
                </p>
            </label>
            <div class="col-xs-1">
                <?php 
                $fld = 'progressBar';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'progressBarHeight';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => t('Position'), 'class' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'progressBarBGColor';
                $ini_value = $record->optionsObj->{$fld};
                echo $ch->output($fld, $ini_value, array('preferredFormat'=>'hex'))
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'progressBarFillColor';
                $ini_value = $record->optionsObj->{$fld};
                echo $ch->output($fld, $ini_value, array('preferredFormat'=>'hex'))
                ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Stop On Hover') ?>
                <p class="text-muted"><?php  echo t('Stop autoplay on mouse hover') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'stopOnHover';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Navigation (Next/Prev Buttons)') ?>
                <p class="text-muted">
                    <?php  echo t('Enable')." | ".t('Position')." | ".t('Size')." | ".t('Thickness')." | ".t('Opacity')." | ".t('Color') ?>
                    <br>
                    <?php  echo t('Use negative number for place pagination inside the slider.') ?>
                    <br>
                    <?php  echo t('Opacity Should be a number between 0-1') ?>
                </p>
            </label>
            <div class="col-xs-1">
                <?php 
                $fld = 'navigation';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'navigationPosition';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '3', 'placeholder' => t('Position'), 'class' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'navigationSize';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => t('Size'), 'class' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'navigationThickness';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => t('Thickness'), 'class' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'navigationOpacity';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '3', 'placeholder' => t('Opacity'), 'class' => ''));
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'navigationColor';
                $ini_value = $record->optionsObj->{$fld};
                echo $ch->output($fld, $ini_value, array('preferredFormat'=>'hex'))
                ?>
            </div>
        </div>
        <div class="row hidden">
            <label class="col-xs-5 control-label">
                <?php  echo t('Navigation Text') ?>
                <p class="text-muted"><?php  echo t('You can customize your own text for navigation.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                echo '<div class="input-group">';
                echo '<span class="input-group-addon">[</span>';
                $fld = 'navigationTextPrev';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '100', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">,</span>';
                $fld = 'navigationTextNext';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '100', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">]</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Pagination (Bullets)') ?>
                <p class="text-muted">
                    <?php  echo t('Enable')." | ".t('Position')." | ".t('Size')." | ".t('Color') ?>
                    <br>
                    <?php  echo t('Use negative number for place pagination inside the slider.') ?>
                </p>
            </label>
            <div class="col-xs-1">
                <?php 
                $fld = 'pagination';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'paginationPosition';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '3', 'placeholder' => 'Pos', 'class' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'paginationSize';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => 'Size', 'class' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'paginationColor';
                $ini_value = $record->optionsObj->{$fld};
                echo $ch->output($fld, $ini_value, array('preferredFormat'=>'hex'))
                ?>
            </div>
        </div>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Pagination Numbers') ?>
                <p class="text-muted"><?php  echo t('Show numbers inside pagination buttons') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'paginationNumbers';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Rewind Nav') ?>
                <p class="text-muted"><?php  echo t('Slide to first item. Use rewindSpeed to change animation speed.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'rewindNav';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Scroll Per Page') ?>
                <p class="text-muted"><?php  echo t('Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'scrollPerPage';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Random') ?>
                <p class="text-muted"><?php  echo t('Randomize slides') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'random';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
    </div>
</div>
<div class="well">
    <h2>
        <?php  echo t('Carousel Advanced Options') ?>&nbsp;
        <a href="#form_carousel_adv_options" class="show-hide pull-right" title="<?php   echo t('Click to Show/Hide')?>"><i class="fa fa-chevron-down"></i></a>
    </h2>
    <div id="form_carousel_adv_options" style="display:none;">
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Items Scale Up') ?>
                <p class="text-muted"><?php  echo t('Option to not stretch items when it is less than the supplied items.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'itemsScaleUp';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Slide Speed') ?>
                <p class="text-muted"><?php  echo t('Slide speed in milliseconds') ?></p>
            </label>
            <div class="col-xs-2">
                <?php 
                $fld = 'slideSpeed';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '4', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">'.t('ms').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-5">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Pagination Speed') ?>
                <p class="text-muted"><?php  echo t('Pagination speed in milliseconds') ?></p>
            </label>
            <div class="col-xs-2">
                <?php 
                $fld = 'paginationSpeed';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '4', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">'.t('ms').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-5">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Rewind Speed') ?>
                <p class="text-muted"><?php  echo t('Rewind speed in milliseconds') ?></p>
            </label>
            <div class="col-xs-2">
                <?php 
                $fld = 'rewindSpeed';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '4', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">'.t('ms').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-5">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Responsive') ?>
                <p class="text-muted"><?php  echo t('You can use Owl Carousel on desktop-only websites too! Just change that to "false" to disable resposive capabilities') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'responsive';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Responsive Refresh Rate') ?>
                <p class="text-muted"><?php  echo t('Check window width changes every 200ms for responsive actions') ?></p>
            </label>
            <div class="col-xs-2">
                <?php 
                $fld = 'responsiveRefreshRate';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '5', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">'.t('ms').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-5">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Lazy Load') ?>
                <p class="text-muted"><?php  echo t("Delays loading of images. Images outside of viewport won't be loaded before user scrolls to them. Great for mobile devices to speed up page loadings.") ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'lazyLoad';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Lazy Follow') ?>
                <p class="text-muted"><?php  echo t('When pagination used, it skips loading the images from pages that got skipped. It only loads the images that get displayed in viewport. If set to false, all images get loaded when pagination used. It is a sub setting of the lazy load function.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'lazyFollow';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Auto Height') ?>
                <p class="text-muted"><?php  echo t('Add height to owl-wrapper-outer so you can use different heights on slides. Use it only for one item per page setting.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'autoHeight';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Drag Before Anim Finish') ?>
                <p class="text-muted"><?php  echo t('Ignore whether a transition is done or not (only dragging).') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'dragBeforeAnimFinish';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Mouse Drag') ?>
                <p class="text-muted"><?php  echo t('Turn off/on mouse events.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'mouseDrag';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Touch Drag') ?>
                <p class="text-muted"><?php  echo t('Turn off/on touch events.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'touchDrag';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-2 control-label">
                <?php  echo t('Transition Style') ?>
                <p class="text-muted"><?php  echo t('Add CSS3 transition style. Works only with one item on screen.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'transitionStyle';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-5">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Transition Style') ?>
                <p class="text-muted"><?php  echo t('Add CSS3 transition style. Works only with one item on screen.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'transitionStyle';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->select($fld, $transitionStyles, $ini_value, array('style' => ''));
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
    </div>
</div>
<div class="well">
    <h2>
        <?php  echo t('Carousel Design') ?>&nbsp;
        <a href="#form_carousel_design" class="show-hide pull-right" title="<?php   echo t('Click to Show/Hide')?>"><i class="fa fa-chevron-down"></i></a>
    </h2>
    <div id="form_carousel_design" style="display:none">
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Carousel Bg Color') ?>
                <p class="text-muted"><?php  echo t('Carousel container background color') ?></p>
            </label>
            <div class="col-xs-8">
                <?php 
                $fld = 'carouselBgColor';
                $ini_value = $record->optionsObj->{$fld};
                echo $ch->output($fld, $ini_value, array('preferredFormat'=>'hex'))
                ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Items Bg Color') ?>
                <p class="text-muted"><?php  echo t('This option will not override bg colors specified at items tab. Use this if you want same background color for all items.') ?></p>
            </label>
            <div class="col-xs-8">
                <?php 
                $fld = 'itemsBgColor';
                $ini_value = $record->optionsObj->{$fld};
                echo $ch->output($fld, $ini_value, array('preferredFormat'=>'hex'))
                ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Font Color') ?>
                <p class="text-muted"><?php  echo t('Font color for items. Leave it blank if you want it to inherit by theme.') ?></p>
            </label>
            <div class="col-xs-8">
                <?php 
                $fld = 'fontColor';
                $ini_value = $record->optionsObj->{$fld};
                echo $ch->output($fld, $ini_value, array('preferredFormat'=>'hex'))
                ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Items Padding') ?>
                <p class="text-muted">
                    <?php  echo t('Use it if you want internal spacing for items.') ?>
                    <br>
                    <?php  echo t('Top:Right:Bottom:Left') ?>
                </p>
            </label>
            <div class="col-xs-5">
                <?php 
                echo '<div class="input-group">';
                $fld = 'itemsPaddingTop';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => '', 'style' => ''));
                echo '<span class="input-group-addon" style="min-width:0px;">:</span>';
                $fld = 'itemsPaddingRight';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => '', 'style' => ''));
                echo '<span class="input-group-addon" style="min-width:0px;">:</span>';
                $fld = 'itemsPaddingBottom';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => '', 'style' => ''));
                echo '<span class="input-group-addon" style="min-width:0px;">:</span>';
                $fld = 'itemsPaddingLeft';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => '', 'style' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Carousel Css') ?>
                <p class="text-muted"><?php  echo t('Styles here affect carousel container.') ?></p>
            </label>
            <div class="col-xs-8">
                <?php 
                $fld = 'carouselCss';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->textarea($fld, $ini_value, array('placeholder' => 'border:...;', 'class' => '', 'style'=>'width:100%;'));
                ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Items Css') ?>
                <p class="text-muted"><?php  echo t('Styles here affect all carousel items.') ?></p>
            </label>
            <div class="col-xs-8">
                <?php 
                $fld = 'itemsCss';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->textarea($fld, $ini_value, array('placeholder' => 'margin:...;', 'class' => '', 'style'=>'width:100%;'));
                ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Items Children Css') ?>
                <p class="text-muted"><?php  echo t('Styles here affect all carousel items children, includes title, description & image.') ?></p>
            </label>
            <div class="col-xs-8">
                <?php 
                $fld = 'itemsChildrenCss';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->textarea($fld, $ini_value, array('placeholder' => 'font-family:...;', 'class' => '', 'style'=>'width:100%;'));
                ?>
            </div>
        </div>

        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Items Images Css') ?>
                <p class="text-muted"><?php  echo t('Styles here affect all carousel items images.') ?></p>
            </label>
            <div class="col-xs-8">
                <?php 
                $fld = 'itemsImagesCss';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->textarea($fld, $ini_value, array('placeholder' => 'font-family:...;', 'class' => '', 'style'=>'width:100%;'));
                ?>
            </div>
        </div>
        <div class="row internal">
            <div class="col-xs-4"><?php  echo t('Templates') ?></div>
            <div class="col-xs-8">
                <?php  foreach ($itemsImagesCssTemplates as $value) { ?>
                    <button class="btn btn-default btn-xs csstemplate" type="button" title="<?php  echo (isset($value['tooltip']))?$value['tooltip']:''?>" target="itemsImagesCss" data="<?php  echo $value['css']?>"><?php  echo $value['title']?></button>
                <?php  } ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Items Titles Css') ?>
                <p class="text-muted"><?php  echo t('Styles here affect all carousel items Titles.') ?></p>
            </label>
            <div class="col-xs-8">
                <?php 
                $fld = 'itemsTitlesCss';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->textarea($fld, $ini_value, array('placeholder' => 'font-family:...;', 'class' => '', 'style'=>'width:100%;'));
                ?>
            </div>
        </div>
        <div class="row internal">
            <div class="col-xs-4"><?php  echo t('Templates') ?></div>
            <div class="col-xs-8">
                <?php  foreach ($itemsTitlesCssTemplates as $value) { ?>
                    <button class="btn btn-default btn-xs csstemplate" type="button" title="<?php  echo (isset($value['tooltip']))?$value['tooltip']:''?>" target="itemsTitlesCss" data="<?php  echo $value['css']?>"><?php  echo $value['title']?></button>
                <?php  } ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Items Descriptions Css') ?>
                <p class="text-muted"><?php  echo t('Styles here affect all carousel items Descriptions.') ?></p>
            </label>
            <div class="col-xs-8">
                <?php 
                $fld = 'itemsDescriptionsCss';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->textarea($fld, $ini_value, array('placeholder' => 'font-family:...;', 'class' => '', 'style'=>'width:100%;'));
                ?>
            </div>
        </div>
        <div class="row internal">
            <div class="col-xs-4"><?php  echo t('Templates') ?></div>
            <div class="col-xs-8">
                <?php  foreach ($itemsDescriptionsCssTemplates as $value) { ?>
                    <button class="btn btn-default btn-xs csstemplate" type="button" title="<?php  echo (isset($value['tooltip']))?$value['tooltip']:''?>" target="itemsDescriptionsCss" data="<?php  echo $value['css']?>"><?php  echo $value['title']?></button>
                <?php  } ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Items Extra Texts Css') ?>
                <p class="text-muted"><?php  echo t('Styles here affect all carousel items ExtraTexts.') ?></p>
            </label>
            <div class="col-xs-8">
                <?php 
                $fld = 'itemsExtraTextsCss';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->textarea($fld, $ini_value, array('placeholder' => 'font-family:...;', 'class' => '', 'style'=>'width:100%;'));
                ?>
            </div>
        </div>
        <div class="row internal">
            <div class="col-xs-4"><?php  echo t('Templates') ?></div>
            <div class="col-xs-8">
                <?php  foreach ($itemsExtraTextsCssTemplates as $value) { ?>
                    <button class="btn btn-default btn-xs csstemplate" type="button" title="<?php  echo (isset($value['tooltip']))?$value['tooltip']:''?>" target="itemsExtraTextsCss" data="<?php  echo $value['css']?>"><?php  echo $value['title']?></button>
                <?php  } ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Styles') ?>
                <p class="text-muted"><?php  echo t('Styles should have selectors and injected into page. So be aware not to insert loose styles that may affect other elements of page.') ?></p>
            </label>
            <div class="col-xs-8">
                <?php 
                $fld = 'styles';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->textarea($fld, $ini_value, array('placeholder' => '.item-description{background-color:#f5f5f5;}', 'class' => '', 'style'=>'width:100%;'));
                ?>
            </div>
        </div>
        <div class="row internal">
            <div class="col-xs-4"><?php  echo t('Templates') ?></div>
            <div class="col-xs-8">
                <?php  foreach ($stylesTemplates as $value) { ?>
                    <button class="btn btn-default btn-xs csstemplate" type="button" title="<?php  echo (isset($value['tooltip']))?$value['tooltip']:''?>" target="styles" data="<?php  echo $value['css']?>"><?php  echo $value['title']?></button>
                <?php  } ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Google Fonts Embed') ?>
                <p class="text-muted"><?php  echo t('') ?></p>
            </label>
            <div class="col-xs-8">
                <?php 
                $fld = 'embedFont';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->textarea($fld, $ini_value, array('placeholder' => "<link href='//fonts.googleapis.com/css?family=Lato:400,900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>", 'class' => '', 'style'=>'width:100%;'));
                ?>
            </div>
        </div>
        <div class="row internal">
            <div class="col-xs-4"><?php  echo t('Templates') ?></div>
            <div class="col-xs-8">
                <?php  foreach ($embedFontTemplates as $value) { ?>
                    <button class="btn btn-default btn-xs csstemplate" type="button" title="<?php  echo (isset($value['tooltip']))?$value['tooltip']:''?>" target="embedFont" data="<?php  echo $value['css']?>"><?php  echo $value['title']?></button>
                <?php  } ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Button') ?>
            </label>
            <div class="col-xs-8">
                <p class="text-muted">
                    <?php  echo t('BG (Color/Opacity)')." | ".t('Font Color')." | ".t('Border (Width/Color/Radius)')." | ".t('Padding (Vertical/Horizontal)') ?>
                </p>
            </div>
        </div>
        <div class="row internal">
            <div class="col-xs-4"><?php  echo t('Default') ?></div>
            <div class="col-xs-1 compact first">
                <?php 
                $fld = 'buttonDefaultBGColor';
                $ini_value = $record->optionsObj->{$fld};
                echo $ch->output($fld, $ini_value, array('preferredFormat'=>'hex'))
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'buttonDefaultBGOpacity';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '3', 'placeholder' => t('Opacity'), 'class' => ''));
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'buttonDefaultFontColor';
                $ini_value = $record->optionsObj->{$fld};
                echo $ch->output($fld, $ini_value, array('preferredFormat'=>'hex'))
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'buttonDefaultBorderWidth';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => t('Width'), 'class' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'buttonDefaultBorderColor';
                $ini_value = $record->optionsObj->{$fld};
                echo $ch->output($fld, $ini_value, array('preferredFormat'=>'hex'))
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'buttonDefaultBorderRadius';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => t('Radius'), 'class' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-2 compact">
                <?php 
                echo '<div class="input-group">';
                $fld = 'buttonDefaultPaddingVer';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => 'Ver', 'style' => ''));
                echo '<span class="input-group-addon" style="min-width:0px;"></span>';
                $fld = 'buttonDefaultPaddingHor';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => 'Hor', 'style' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
        </div>
        <div class="row internal">
            <div class="col-xs-4"><?php  echo t('Hover') ?></div>
            <div class="col-xs-1 compact first">
                <?php 
                $fld = 'buttonHoverBGColor';
                $ini_value = $record->optionsObj->{$fld};
                echo $ch->output($fld, $ini_value, array('preferredFormat'=>'hex'))
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'buttonHoverBGOpacity';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '3', 'placeholder' => t('Opacity'), 'class' => ''));
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'buttonHoverFontColor';
                $ini_value = $record->optionsObj->{$fld};
                echo $ch->output($fld, $ini_value, array('preferredFormat'=>'hex'))
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'buttonHoverBorderWidth';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => t('Width'), 'class' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'buttonHoverBorderColor';
                $ini_value = $record->optionsObj->{$fld};
                echo $ch->output($fld, $ini_value, array('preferredFormat'=>'hex'))
                ?>
            </div>
            <div class="col-xs-1 compact">
                <?php 
                $fld = 'buttonHoverBorderRadius';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => t('Radius'), 'class' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
            <div class="col-xs-2 compact">
                <?php 
                echo '<div class="input-group">';
                $fld = 'buttonHoverPaddingVer';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => 'Ver', 'style' => ''));
                echo '<span class="input-group-addon" style="min-width:0px;"></span>';
                $fld = 'buttonHoverPaddingHor';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->text($fld, $ini_value, array('maxlength' => '2', 'placeholder' => 'Hor', 'style' => ''));
                echo '<span class="input-group-addon">'.t('px').'</span>';
                echo '</div>';
                ?>
            </div>
        </div>
        <div class="row internal">
            <div class="col-xs-4">
                <?php  echo t('Css') ?>
                <p class="text-muted"><?php  echo t('') ?></p>
            </div>
            <div class="col-xs-8">
                <?php 
                $fld = 'buttonCss';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->textarea($fld, $ini_value, array('placeholder' => 'font-size:16px;', 'class' => '', 'style'=>'width:100%;'));
                ?>
            </div>
        </div>


    </div>
</div>
<div class="well">
    <h2>
        <?php  echo t('Animation') ?>&nbsp;
        <a href="#form_animation" class="show-hide pull-right" title="<?php   echo t('Click to Show/Hide')?>"><i class="fa fa-chevron-down"></i></a>
    </h2>
    <div id="form_animation" style="display:none">
    <div class="row">
        <div class="col-xs-6">
        <hr>
        <div class="row">
            <label class="col-xs-7 control-label">
                <?php  echo t('Disable Animation') ?>
                <p class="text-muted"><?php  echo t('Check this if you do not need animation library and do not want it to include related assets at your pages.') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'animationDisable';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array('target'=>'.animation-disabled-related'));
                ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-7 control-label">
                <?php  echo t('Animation Effect') ?>
                <p class="text-muted"><?php  echo t('Animation effect can be set for every slide at Slides tab.') ?></p>
            </label>
            <div class="col-xs-5">
                <div class="input-group">
                    <?php 
                    $fld = 'animationEffect';
                    $ini_value = $record->optionsObj->{$fld};
                    echo $fh->select($fld, $animationEffects, $ini_value, array('style' => ''));
                    ?>
                    <span class="input-group-addon" id="animate-repeat" title="<?php  echo t('Repeat') ?>"><i class="fa fa-repeat" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        <hr>
        <div class="row animation-disabled-related">
            <label class="col-xs-7 control-label">
                <?php  echo t('Animation Duration') ?>
                <p class="text-muted"><?php  echo t('') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'animationDuration';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '5', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">'.t('ms').'</span>';
                echo '</div>';
                ?>
            </div>
        </div>
        <hr>
        <div class="row animation-disabled-related">
            <label class="col-xs-7 control-label">
                <?php  echo t('Animation Delay') ?>
                <p class="text-muted"><?php  echo t('') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'animationDelay';
                $ini_value = $record->optionsObj->{$fld};
                echo '<div class="input-group">';
                echo $fh->text($fld, $ini_value, array('maxlength' => '5', 'placeholder' => '', 'class' => ''));
                echo '<span class="input-group-addon">'.t('ms').'</span>';
                echo '</div>';
                ?>
            </div>
        </div>
        <hr>
        </div>

        <div class="col-xs-6" style="">
            <div class="animation-display" style="">
                <span class="anim-txt" >
                    <?php  echo (Config::get('whale_owl_carousel.animate_text')) ? Config::get('whale_owl_carousel.animate_text') : t('Whale'); ?>
                </span>
            </div>
        </div>
    </div>

    </div>
</div>


</DIV>
<!-- End: Carousel Tab -->

<!-- Begin: Slides Tab -->
<DIV class="ccm-tab-content" id="ccm-tab-content-slides" style="padding-top:0px;">

    <!--Fill Buttons-->
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-info btn-sm" id="fill-titles" title="<?php  echo t("Fill Slider Header with Title attribute")?>"><?php  echo t("T")?></button>
        <button type="button" class="btn btn-info btn-sm" id="fill-descriptions" title="<?php  echo t("Fill Description Header with Description attribute")?>"><?php  echo t("D")?></button>
    </div>

    <!--Add Buttons-->
    <a href="#" class="btn btn-success btn-sm pull-right" style="margin-left: 10px;" id="add-slide-1" title="<?php  echo t("Add New Slide")?>">
        <i class="fa fa-plus-circle"></i>
        <?php  echo t("Add New Slide")?>
    </a>
    <div class="clearfix"></div>
    <div class="ccm-image-slider-entries">&nbsp;</div>
    <a href="#" class="btn btn-success btn-sm pull-right" style="margin-left: 10px;" id="add-slide-2">
        <i class="fa fa-plus-circle" title="<?php  echo t("Add New Slide")?>"></i>
        <?php  echo t("Add New Slide")?>
    </a>

</DIV>
<!-- End: Slides Tab -->

<!-- Begin: Lightbox Tab -->
<DIV class="ccm-tab-content" id="ccm-tab-content-lightbox" style="padding-top:0px;">
<div class="well">
    <h2>
        <?php  echo t('Carousel Lightbox') ?>&nbsp;
        <a href="#form_carousel_lightbox" class="show-hide pull-right" title="<?php   echo t('Click to Show/Hide')?>"><i class="fa fa-chevron-up"></i></a>
    </h2>
    <div id="form_carousel_lightbox" style="display:">
        <div class="row">
            <label class="col-xs-12 control-label">
                <p class="text-muted"><?php  echo t('Enable Lightbox overrides items links on images.') ?></p>
                <p class="text-muted"><?php  echo t('Lightbox uses original image size. It is a good practice to use smaller image sizes for carousel items. You can define Width/Height of every image at the slides boxes.') ?></p>
            </label>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Show Title') ?>
                <p class="text-muted"><?php  echo t('Show Title at the Lightbox') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'lightboxShowTitle';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <h4><?php  echo t('Show Description') ?></h4>
                <p class="text-muted"><?php  echo t('Show Description at the Lightbox') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'lightboxShowDescription';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Effect') ?>
                <p class="text-muted"><?php  echo t('The effect to use when showing the lightbox') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'lightboxEffect';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->select($fld, $lightboxEffects, $ini_value, array('style' => ''));
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Theme') ?>
                <p class="text-muted"><?php  echo t('The lightbox theme to use') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'lightboxTheme';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->select($fld, $lightboxThemes, $ini_value, array('style' => ''));
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Keyboard Nav') ?>
                <p class="text-muted"><?php  echo t('Enable/Disable keyboard navigation (left/right/escape)') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'lightboxKeyboardNav';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Click Overlay To Close') ?>
                <p class="text-muted"><?php  echo t('If false clicking the "close" button will be the only way to close the lightbox') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'lightboxClickOverlayToClose';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-5 control-label">
                <?php  echo t('Touch Wipe') ?>
                <p class="text-muted"><?php  echo t('Add touch wipe to the lightbox') ?></p>
            </label>
            <div class="col-xs-5">
                <?php 
                $fld = 'lightboxTouchWipe';
                $ini_value = $record->optionsObj->{$fld};
                echo $fh->checkbox($fld, 1, $ini_value, array());
                ?>
            </div>
            <div class="col-xs-2">&nbsp;</div>
        </div>
    </div>
</div>
</DIV>
<!-- End: Lightbox Tab -->


<!-- Begin: Buttons -->
        <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <a href="<?php  echo URL::page($c)?>" class="btn btn-default pull-left"><?php  echo t('Back')?></a>
            <?php  echo $fh->submit('ccm-update', $buttonText, array('class'=>'btn btn-primary pull-right')); ?>
            <?php  if($task=='update') echo $fh->submit('ccm-update2', $buttonText2, array('class'=>'btn btn-primary pull-right', 'style'=>'margin-right:5px;')); ?>
        </div>
        </div>
<!-- END: Buttons -->

</div>
</form>

<!--END: Add/Edit Form-->
<?php   }else{ ?>
<!--BEGIN: GRID-->

<?php  if(Config::get('whale_owl_carousel.notice_list')){ ?>
<div class="alert alert-info" role="alert"><?php  echo Config::get('whale_owl_carousel.notice_list')?></div>
<?php  } ?>

<div class="ccm-dashboard-content-full">

    <div class="ccm-dashboard-header-buttons">
        <a class="btn btn-primary" href="<?php   echo $this->action('add')?>">
            <i title="Add" class="fa fa-plus-circle"></i>
            <?php   echo t('Add New Carousel');?>
        </a>
    </div>

    <div data-search-element="wrapper">
        <form role="form" data-search-form="owl-carousel" action="<?php  echo $controller->action('view')?>" class="form-inline ccm-search-fields">
            <div class="ccm-search-fields-row">
                 <div class="form-group" style="width:97%;">
                        <?php  echo $fh->label('fKeywords', t('Search'))?>
                        <div class="ccm-search-field-content">
                            <div class="ccm-search-main-lookup-field">
                                <i class="fa fa-search"></i>
                                <?php  echo $fh->search('fKeywords', array('placeholder' => t('Keywords')))?>
                                <button type="submit" class="ccm-search-field-hidden-submit" tabindex="-1"><?php  echo t('Search')?></button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info pull-right"><?php  echo t('Search')?></button>
                    </div>
                </div>
            <div class="ccm-search-fields-submit">

            </div>
        </form>
    </div>

    <form method="post" action="<?php   echo $this->action('mass_update')?>" id="mass-update-form">
    <div data-search-element="results">
        <div class="table-responsive">

        <?php  if(count($list) > 0) { ?>
            <table class="ccm-search-results-table">
                <thead>
                <tr>
                    <th><span><input id="ccm-list-cb-all" type="checkbox" data-search-checkbox="select-all"></span></th>
                    <th><span><?php   echo t('ID')?></span></th>
                    <th><span><?php   echo t('Name')?></span></th>
                    <th><span><?php   echo t('Plugin')?></span></th>
                    <th><span><?php   echo t('Theme')?></span></th>
                    <th><span><?php   echo t('Operations')?></span></th>
                </tr>
                </thead>
                <tbody>
                <?php   foreach((array)$list as $item){ ?>
                <tr>
                    <td class="ccm-list-cb" style="vertical-align: middle !important"><input name="cb_items[]" type="checkbox" value="<?php  echo $item['id']?>" data-search-checkbox="individual"/></td>
                    <td><?php  echo $item['id'] ?></td>
                    <td><?php  echo $item['carouselName'] ?>&nbsp;</td>
                    <td><?php  echo isset($carouselPlugins[$item['carouselPlugin']])?$carouselPlugins[$item['carouselPlugin']]:'-' ?>&nbsp;</td>
                    <td><?php  echo isset($carouselThemes[$item['carouselTheme']])?$carouselThemes[$item['carouselTheme']]:'-' ?>&nbsp;</td>
                    <td>
                        <a href="<?php   echo $this->action('edit/'.$item['id'])?>" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                            <?php   echo t("Edit")?>
                        </a>
                    </td>
                </tr>
                <?php   } ?>
                </tbody>
            </table>
        <?php  }else{ ?>
            <div class="ccm-search-fields-row" style="font-weight: bold;">
            <?php   echo t('No record found.') ?>
            </div>
        <?php  } ?>

        </div>
    </div>

    <?php  echo (isset($l))?$l->displayPagingV2():''?>

    <?php  if(count($list) > 0) {?>
    <!-- Begin: Buttons -->
        <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <?php  //echo $fh->submit('ccm-delete', t('Delete'), array('style' => '', 'class'=>'btn btn-danger pull-right', 'onclick'=>'return confirm_delete()')); ?>
            <?php 
            echo $fh->submit('ccm-mass-update', t('Delete'), array('style' => 'margin-right:5px;', 'class'=>'btn btn-danger pull-right', 'onclick'=>'return confirm_delete()'));
            echo $fh->submit('ccm-mass-update', t('Duplicate'), array('style' => 'margin-right:5px;', 'class'=>'btn btn-primary pull-right', 'onclick'=>''));
            ?>
        </div>
        </div>
    <!-- : Buttons -->
    <?php  } ?>

    </form>
</div>

<!--END: GRID-->
<?php   } ?>


<script type="text/javascript">
    $(document).ready(function(){
        var sliderEntriesContainer = $('.ccm-image-slider-entries');
        var _templateSlide = _.template($('#imageTemplate').html());

        var attachFileManagerLaunch = function($obj) {
            $obj.click(function(){
                var oldLauncher = $(this);
                ConcreteFileManager.launchDialog(function (data) {
                    ConcreteFileManager.getFileDetails(data.fID, function(r) {
                        jQuery.fn.dialog.hideLoader();
                        var file = r.files[0];

                        oldLauncher.html(file.resultsThumbnailImg);
                        oldLauncher.next('.image-itemImageID').val(file.fID);
                        oldLauncher.next('.image-itemImageID').attr('data-title',file.title);
                        oldLauncher.next('.image-itemImageID').attr('data-description',file.description);
                    });
                });
            });
        }

        sliderEntriesContainer.on('change', 'select[data-field=item-url-type-select]', function() {
            var container = $(this).closest('.ccm-image-slider-entry');
            switch($(this).val()) {
                case 'internal':
                    container.find('div[data-field=item-url-external-container]').hide();
                    container.find('div[data-field=item-url-internal-container]').show();
                    break;
                case 'external':
                    container.find('div[data-field=item-url-internal-container]').hide();
                    container.find('div[data-field=item-url-external-container]').show();
                    break;
                default:
                    container.find('div[data-field=item-url-internal-container]').hide();
                    container.find('div[data-field=item-url-external-container]').hide();
                    break;
            }
        });

       <?php  if($record->itemsObj) {
           foreach ($record->itemsObj as $row) { ?>
           //alert('<?php  echo $row->itemImageID ?>');
           sliderEntriesContainer.append(_templateSlide({
                itemImageID: '<?php  echo $row->itemImageID ?>',
                <?php  if($row->itemImageID && File::getByID($row->itemImageID)) { ?>
                    image_url: '<?php  echo File::getByID($row->itemImageID)->getThumbnailURL('file_manager_listing');?>',
                    image_title: '<?php  echo File::getByID($row->itemImageID)->getApprovedVersion()->getTitle();?>',
                    image_description: '<?php  echo File::getByID($row->itemImageID)->getApprovedVersion()->getDescription();?>',
                <?php  } else { ?>
                    image_url: '',
                    image_title: '',
                    image_description: '',
                <?php  } ?>

                captionPosition: '<?php  echo $row->captionPosition ?>',
                captionAlign: '<?php  echo $row->captionAlign ?>',
                captionPadding: '<?php  echo $row->captionPadding ?>',
                captionAnimation: '<?php  echo $row->captionAnimation ?>',

                itemHeader: '<?php  echo addslashes($row->itemHeader) ?>',
                itemHeaderType: '<?php  echo $row->itemHeaderType ?>',
                itemDescription: '<?php  echo addslashes($row->itemDescription) ?>',
                itemExtraText: '<?php  echo addslashes($row->itemExtraText) ?>',
                //cID: '',
                itemUrlWrapper: '<?php  echo $row->itemUrlWrapper ?>',
                itemUrlLabel: '<?php  echo $row->itemUrlLabel ?>',
                itemUrlType: '<?php  echo $row->itemUrlType ?>',
                itemUrlNewWindow: '<?php  echo $row->itemUrlNewWindow ?>',
                itemUrl: '<?php  echo $row->itemUrl ?>',
                itemUrlInternal: '<?php  echo $row->itemUrlInternal ?>',
                itemUrlExternal: '<?php  echo $row->itemUrlExternal ?>',
                itemImageWidth: '<?php  echo $row->itemImageWidth ?>',
                itemImageHeight: '<?php  echo $row->itemImageHeight ?>',
                itemBgColor: '<?php  echo $row->itemBgColor ?>',
                itemActive: '<?php  echo $row->itemActive ?>',
                containerTitle: '<?php  echo t('Slide') ?>',
                itemID: '<?php  echo $row->itemID ?>',

                captionPositionsJson : <?php  echo $captionPositionsJson;?>,
                captionAlignsJson : <?php  echo $captionAlignsJson;?>,
                animationEffectsJson : <?php  echo $animationEffectsJson;?>,
            }));
            sliderEntriesContainer.find('.ccm-image-slider-entry:last-child div[data-field=item-url-internal-container]').concretePageSelector({
                'inputName': 'itemUrlInternal[]',
                'cID': <?php  if ($row->itemUrlType == 'internal') { ?><?php  echo intval($row->itemUrlInternal)?><?php  } else { ?>false<?php  } ?>
            });
        <?php  }
        }?>
        sliderEntriesContainer.find('select[data-field=item-url-type-select]').trigger('change');

        $('#add-slide-1').add('#add-slide-2').click(function(){
           var thisModal = $(this).closest('.ui-dialog-content');
            newItemID = sliderEntriesContainer.find($('.ccm-image-slider-entry')).size();
            sliderEntriesContainer.append(_templateSlide({
                itemImageID: '',
                image_url: '',
                image_title: '',
                image_description: '',

                captionPosition: '<?php  echo $record->itemsTmpObj->captionPosition ?>',
                captionAlign: '<?php  echo $record->itemsTmpObj->captionAlign ?>',
                captionPadding: '<?php  echo $record->itemsTmpObj->captionPadding ?>',
                captionAnimation: '<?php  echo $record->itemsTmpObj->captionAnimation ?>',

                itemHeader: '<?php  echo $record->itemsTmpObj->itemHeader ?>',
                itemHeaderType: '<?php  echo $record->itemsTmpObj->itemHeaderType ?>',
                itemDescription: '<?php  echo $record->itemsTmpObj->itemDescription ?>',
                itemExtraText: '<?php  echo $record->itemsTmpObj->itemExtraText ?>',
                //cID: '',
                itemUrlWrapper: '<?php  echo $record->itemsTmpObj->itemUrlWrapper ?>',
                itemUrlLabel: '<?php  echo $record->itemsTmpObj->itemUrlLabel ?>',
                itemUrlType: '<?php  echo $record->itemsTmpObj->itemUrlType ?>',
                itemUrlNewWindow: '<?php  echo $record->itemsTmpObj->itemUrlNewWindow ?>',
                itemUrl: '<?php  echo $record->itemsTmpObj->itemUrl ?>',
                itemUrlInternal: '<?php  echo $record->itemsTmpObj->itemUrlInternal ?>',
                itemUrlExternal: '<?php  echo $record->itemsTmpObj->itemUrlExternal ?>',
                itemImageWidth: '<?php  echo $record->itemsTmpObj->itemImageWidth ?>',
                itemImageHeight: '<?php  echo $record->itemsTmpObj->itemImageHeight ?>',
                itemBgColor: '<?php  echo $record->itemsTmpObj->itemBgColor ?>',
                itemActive: '<?php  echo $record->itemsTmpObj->itemActive ?>',
                //sort_order: '',
                containerTitle: '<?php  echo t('Slide').' ('.t('New').')' ?>',
                itemID: newItemID,

                captionPositionsJson : <?php  echo $captionPositionsJson;?>,
                captionAlignsJson : <?php  echo $captionAlignsJson;?>,
                animationEffectsJson : <?php  echo $animationEffectsJson;?>,
            }));
            var newItem = $('.ccm-image-slider-entry').last();
            //thisModal.scrollTop(newItem.offset().top);
            //attachDelete(newSlide.find('.ccm-delete-image-slider-entry'));
            attachFileManagerLaunch(newItem.find('.ccm-pick-slide-image'));
            newItem.find('div[data-field=item-url-internal-container]').concretePageSelector({
                'inputName': 'itemUrlInternal[]'
            });
            //attachSortDesc(newSlide.find('i.fa-sort-desc'));
            //attachSortAsc(newSlide.find('i.fa-sort-asc'));
            //doSortCount();
            newItem.addClass("new-slide");
            $('html,body').animate({scrollTop: newItem.offset().top},'slow');
        });
        //attachDelete($('.ccm-delete-image-slider-entry'));
        //attachSortAsc($('i.fa-sort-asc'));
        //attachSortDesc($('i.fa-sort-desc'));
        attachFileManagerLaunch($('.ccm-pick-slide-image'));
    });
</script>

<script type="text/template" id="imageTemplate">
<div class="ccm-image-slider-entry well" id="item-<%= itemID %>">
    <?php 
    //echo $fh->hidden('itemID[]', $itemInfo->itemID, array('class' => 'itemID'));
    ?>
    <!--//just for counting items(because all fields are optional)-->
    <input type="hidden" name="itemID[]" value="<%=itemID%>" />
    <h2>
        <span class="slide-title"><%= containerTitle %></span>
        <a href="#form_slide_adv" class="show-hide pull-right" style="margin-left:5px;" title="<?php  echo t('Click to Show/Hide more options')?>"><i class="fa fa-chevron-down"></i></a>
        <a href="#" class="remove-slide pull-right" style="margin-left:5px;" title="<?php  echo t('Click to Remove slide')?>"><i class="fa fa-remove"></i></a>
        <a href="#form_slide" class="move-slide pull-right" style="margin-left:5px;cursor:move;" title="<?php  echo t('Drag to Move slide')?>"><i class="fa fa-arrows"></i></a>
    </h2>

    <div class="form-options">
        <hr>
        <div class="row">
            <div class="col-xs-12">
            <label><?php  echo t('Slide Image') ?></label>
            <div class="ccm-pick-slide-image">
                <% if (image_url.length > 0) { %>
                    <img src="<%= image_url %>"/>
                <% } else { %>
                    <i class="fa fa-picture-o"></i>
                <% } %>
            </div>
            <input type="hidden" name="itemImageID[]" class="image-itemImageID" value="<%=itemImageID%>" data-title="<%= image_title %>" data-description="<%= image_description %>"/>
            </div>
        </div>


        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Caption Properties') ?>
                <p class="text-muted">
                    <?php  echo t('Position : Text Align : Padding : Animation') ?>
                    <br>
                    <?php  echo t('Animation only works if it wasn\'t disabled at Animation panel.') ?>
                    <br>
                    <?php  echo t('Animation can set globally via Animation panel') ?>
                </p>    
            </label>
            <div class="col-xs-2" style="padding-right:0px;">
                <select data-field="caption-position-select" name="captionPosition[]" class="form-control">
                <% _.each(captionPositionsJson, function (val,key) {%>
                    <option value="<%=key %>" <% if (captionPosition == key) { %>selected<% } %>> <%=val %> </option>
                <% }); %>
                </select>
            </div>
            <div class="col-xs-2">
                <select data-field="caption-align-select" name="captionAlign[]" class="form-control">
                <% _.each(captionAlignsJson, function (val,key) {%>
                    <option value="<%=key %>" <% if (captionAlign == key) { %>selected<% } %>> <%=val %> </option>
                <% }); %>
                </select>
            </div>
            <div class="col-xs-2">
                <div class="input-group">
                <input type="text" name="captionPadding[]" value="<%=captionPadding%>" class="form-control" maxlength="2"/>
                <span class="input-group-addon"><?php  echo t('%')?>&nbsp;</span>
                </div>
            </div>
            <div class="col-xs-2">
                <select data-field="caption-animation-select" name="captionAnimation[]" class="form-control">
                <% _.each(animationEffectsJson, function (val,key) {%>
                    <option value="<%=key %>" <% if (captionAnimation == key) { %>selected<% } %>> <%=val %> </option>
                <% }); %>
                </select>
            </div>
        </div>

        

        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Slider Header') ?>
            </label>
            <div class="col-xs-6" style="padding-right:0px;">
                <input type="text" name="itemHeader[]" value="<%=itemHeader%>" class="form-control"/>
            </div>
            <div class="col-xs-2">
                <select data-field="item-header-type-select" name="itemHeaderType[]" class="form-control">
                    <option value="h1" <% if (itemHeaderType == "h1") { %>selected<% } %>><?php  echo t('h1')?></option>
                    <option value="h2" <% if (itemHeaderType == "h2") { %>selected<% } %>><?php  echo t('h2')?></option>
                    <option value="h3" <% if (itemHeaderType == "h3") { %>selected<% } %>><?php  echo t('h3')?></option>
                    <option value="h4" <% if (itemHeaderType == "h4") { %>selected<% } %>><?php  echo t('h4')?></option>
                    <option value="h5" <% if (itemHeaderType == "h5") { %>selected<% } %>><?php  echo t('h5')?></option>
                    <option value="h6" <% if (itemHeaderType == "h6") { %>selected<% } %>><?php  echo t('h6')?></option>
                </select>

            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Slide Description') ?>
                <p class="text-muted"></p>
            </label>
            <div class="col-xs-8">
                <textarea name="itemDescription[]" class="form-control"><%=itemDescription%></textarea>
            </div>
        </div>
        <DIV style="display:none;" id="form_slide_adv">
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Slide ExtraText') ?>
                <p class="text-muted"><?php  echo t('Styles here affect all carousel items children, includes images, titles, descriptions & extra texts.') ?></p>
            </label>
            <div class="col-xs-8">
                <input type="text" name="itemExtraText[]" value="<%=itemExtraText%>" class="form-control"/>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('URL') ?>
                <p class="text-muted">
                    <?php  echo t('Wrapper')." | ".t('Label')." | ".t('Type')." | ".t('Target (New Windows)') ?>
                </p>
            </label>
            <div class="col-xs-2" style="padding-right:0px;">
                <select data-field="item-url-wrapper-select" name="itemUrlWrapper[]" class="form-control" style="" onChange="toggleUrlWrapper.call(this)">
                    <option value="slide" <% if (itemUrlWrapper == 'slide') { %>selected<% } %>><?php  echo t('Slide')?></option>
                    <option value="button" <% if (itemUrlWrapper == 'button') { %>selected<% } %>><?php  echo t('Button')?></option>
                </select>
            </div>
            <div class="col-xs-2">
                <input type="text" name="itemUrlLabel[]" value="<%=itemUrlLabel%>" class="form-control itemUrlLabel" readonly="readonly"/>
            </div>
            <div class="col-xs-2" style="padding-right:0px;">
                <select data-field="item-url-type-select" name="itemUrlType[]" class="form-control" style="">
                    <option value="" <% if (!itemUrlType) { %>selected<% } %>><?php  echo t('None')?></option>
                    <option value="internal" <% if (itemUrlType == 'internal') { %>selected<% } %>><?php  echo t('Internal')?></option>
                    <option value="external" <% if (itemUrlType == 'external') { %>selected<% } %>><?php  echo t('External')?></option>
                </select>
            </div>
            <div class="col-xs-2">
                <select data-field="item-url-new-window-select" name="itemUrlNewWindow[]" class="form-control" style="">
                    <option value="0" <% if (itemUrlNewWindow == 0) { %>selected<% } %>><?php  echo t('No')?></option>
                    <option value="1" <% if (itemUrlNewWindow == 1) { %>selected<% } %>><?php  echo t('Yes')?></option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">&nbsp;</div>
            <div class="col-xs-8">
                <div style="display: none;" data-field="item-url-internal-container">
                    <div data-field="item-url-page-selector-select"></div>
                </div>
                <div style="display: none;" data-field="item-url-external-container">
                    <input type="text" name="itemUrlExternal[]" value="<%=itemUrlExternal%>" class="form-control" placeholder="http://">
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Slide Image Size') ?>
                <p class="text-muted"><?php  echo t('For default width/height, leave them empty or 0.') ?></p>
            </label>
            <div class="col-xs-3">
                <div class="input-group">
                    <span class="input-group-addon"><?php  echo t('Width')?>&nbsp;</span>
                    <input type="text" name="itemImageWidth[]" value="<%=itemImageWidth%>" class="form-control"/>
                    <span class="input-group-addon"><?php  echo t('px')?></span>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><?php  echo t('Height')?></span>
                    <input type="text" name="itemImageHeight[]" value="<%=itemImageHeight%>" class="form-control"/>
                    <span class="input-group-addon"><?php  echo t('px')?></span>
                </div>
            </div>
            <div class="col-xs-5"></div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Item Bg Color') ?>
                <p class="text-muted"><?php  echo t('Bg Color in HEX') ?></p>
            </label>
            <div class="col-xs-3">
                <div class="input-group">
                <span class="input-group-addon"><?php  echo t('#')?>&nbsp;</span>
                <input type="text" name="itemBgColor[]" value="<%=itemBgColor%>" class="form-control" maxlength="6"/>
                </div>
            </div>
            <div class="col-xs-5">
                <?php 
                ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <label class="col-xs-4 control-label">
                <?php  echo t('Active') ?>
                <p class="text-muted"></p>
            </label>
            <div class="col-xs-8">
                <input type="checkbox" value="<%=itemID%>" name="itemActive[]" <% if (itemActive == "1") { %>checked<% } %>>
            </div>
        </div>
        </DIV>
    </div>

</div>
</script>

<script type="text/javascript">
$(document).ready(function () {
});
//delete confirmation
function confirm_delete(){
    msg = "<?php  echo t('Deleting a carousel will remove all block instances using that carousel on all pages, are you sure?') ?>";
    return confirm(msg);
}
</script>
