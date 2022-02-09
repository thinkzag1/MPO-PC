<?php
namespace Concrete\Package\GondReadMoreTrial\Block\GondReadMoreTrialTop;

defined('C5_EXECUTE') or die("Access Denied.");

use Concrete\Core\Block\BlockController;

class Controller extends BlockController
{
    protected $btDefaultSet = 'basic';
    protected $btSupportsInlineAdd = false;
    protected $btSupportsInlineEdit = false;
    protected $btCacheBlockOutput = true;

    public function getBlockTypeName()
    {
        return t('Read More Top (TRIAL)');
    }

    public function getBlockTypeDescription()
    {
        return t('A "read more/less" wrapper for your content: top marker. TRIAL VERSION.');
    }
}
