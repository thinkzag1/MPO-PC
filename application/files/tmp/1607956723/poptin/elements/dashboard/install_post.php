<?php

defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Support\Facade\Url;
?>

<div class="alert alert-info" role="alert">
    <p>
        <?php
        echo t('Poptin has been installed successfully. ' .
            'Please go to the settings page to configure the add-on.'
        );
        ?>
    </p>
</div>

<a class="btn btn-primary" href="<?php echo Url::to('/dashboard/system/poptin'); ?>">
    <?php echo t('Settings') ?>
</a>
