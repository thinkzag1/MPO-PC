<?php

namespace Concrete\Package\GondReadMoreTrial;

use Concrete\Core\Package\Package;
use BlockType;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends Package
{
    protected $pkgHandle = 'gond_read_more_trial';
    protected $appVersionRequired = '5.7.5.6';
    protected $pkgVersion = '1.1.0';

    public function getPackageDescription()
    {
        return t('Restrict the visible height of blocks until "Read More" is selected. TRIAL VERSION: '.
                'this package is not fully functional, and is only intended to be used to verify that the full '.
                '"Read More" package will work in your environment. To obtain the full package, please visit %s',
                'https://www.concrete5.org/marketplace/addons/read-more.');
    }

    public function getPackageName()
    {
        return t('Read More (Trial)');
    }

    public function install()
    {
        $pkg = parent::install();

        $bt = BlockType::getByHandle('gond_read_more_trial_top');
        if (!is_object($bt)) {
            BlockType::installBlockType('gond_read_more_trial_top', $pkg);
        }

        $bt = BlockType::getByHandle('gond_read_more_trial_bottom');
        if (!is_object($bt)) {
            BlockType::installBlockType('gond_read_more_trial_bottom', $pkg);
        }
    }
}