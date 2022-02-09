<?php defined('C5_EXECUTE') or die('Access Denied.');

if (Page::getCurrentPage()->isEditMode()) {
    $urlHelper = Core::make('helper/concrete/urls');
    $localPath = $urlHelper->getBlockTypeAssetsURL($blockType);
    ?>
    <div style="background: white; border: 1px solid black; padding: 10px; display: inline-block;">
        <img src="<?php echo $localPath ?>/icon.png" height="24" width="24" style="margin-right:4px;">
        <?php echo t('Read More (Bottom). TRIAL VERSION.'); ?>
    </div>
<?php } else { /* not editing the page */
    $btName = $blockType->getBlockTypeName();
    $bUID = $controller->getBlockUID($b);
    $bUID = intval($bUID);

    // If page is using a grid container, capture the row div HTML for passing to auto.js:
    $page = Page::getCurrentPage();
    $theme = $page->getCollectionThemeObject();
    if ($theme != null) {
        $grid = $theme->getThemeGridFrameworkObject();
        if ($grid != null) {
            $rowHTML = $grid->getPageThemeGridFrameworkRowStartHTML();
            $rowClasses = $controller->getRowClasses($rowHTML);
        }
    } ?>
    <div id="gond-read-more<?php echo $bUID ?>"
            class="gond-read-more-trial-bottom"
            data-collapsed-height="150"
            data-read-more-text="<?php echo t('Read more (TRIAL)') ?>"
            data-read-less-text="<?php echo t('Read less (TRIAL)') ?>"
            data-speed="2"
            data-show-fade="1">
        <script>
            if (typeof(gond_read_more_trial) === "undefined") {
                var gond_read_more_trial = {
                    <?php if ($rowClasses != "") echo "rowClasses: ['$rowClasses'],"; ?>
                    errPrefix: "<?php echo $btName.t(' block with id=') ?>",
                    errCrossColumn: "<?php echo t(': attempting to find Top block across layout columns.') ?>",
                    errLevelMismatch: "<?php echo t(': matching Top block is at a different level within the DOM.') ?>",
                    errNoMatch: "<?php echo t(': matching Top block not found.') ?>",
                    errNotInAncestor: "<?php echo t(': couldn\'t locate block within ancestor.') ?>"
                }
            }
        </script>
    </div>
<?php }
