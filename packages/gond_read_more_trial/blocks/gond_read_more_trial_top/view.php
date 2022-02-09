<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<?php if (Page::getCurrentPage()->isEditMode()) {
    $urlHelper = Core::make('helper/concrete/urls');
    $blockType = BlockType::getByHandle('gond_read_more_trial_top');
    $localPath = $urlHelper->getBlockTypeAssetsURL($blockType);
    ?>
    <div style="background: white; border: 1px solid black; padding: 10px; display: inline-block;">
        <img src="<?php echo $localPath ?>/icon.png" height="24" width="24" style="margin-right:4px;">
        <?php echo t('Read More (Top). TRIAL VERSION.'); ?>
    </div>
<?php  } else { ?>
    <div class="gond-read-more-trial-top"></div>
<?php } ?>
