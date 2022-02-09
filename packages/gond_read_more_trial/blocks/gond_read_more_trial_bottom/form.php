<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<div class="form-group">
    <p>
        <?php echo t("This package is only intended to be used to verify that the <a href='%s'>full 'Read More' package</a> will work in your environment.",
            'https://www.concrete5.org/marketplace/addons/read-more') ?>
    </p>
    <p>
        <?php echo t('The full version gives you control over:') ?>
    </p>
    <ul>
        <li><?php echo t('initial (collapsed) height') ?></li>
        <li><?php echo t('text displayed on "read more/less" buttons') ?></li>
        <li><?php echo t('whether to use a fade-out effect when collapsed') ?></li>
        <li><?php echo t('rate at which the blocks are revealed/collapsed') ?></li>
    </ul>

    <p>
        <?php echo t("You can get the full package from the <a href='%s'>concrete5 Marketplace</a>.",
            'https://www.concrete5.org/marketplace/addons/read-more'); ?>
    </p>
</div>
