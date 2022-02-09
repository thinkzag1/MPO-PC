<?php
namespace Concrete\Package\GondReadMoreTrial\Block\GondReadMoreTrialBottom;

defined('C5_EXECUTE') or die("Access Denied.");

use Concrete\Core\Block\BlockController;

class Controller extends BlockController
{

    protected $btInterfaceWidth = 440;
    protected $btInterfaceHeight = 270;
    protected $btDefaultSet = 'basic';
    protected $btCacheBlockOutput = true;

    public function getBlockTypeName()
    {
        return t('Read More Btm (TRIAL)');
    }

    public function getBlockTypeDescription()
    {
        return t('A "read more/less" wrapper for your content: bottom marker. TRIAL VERSION.');
    }

    public function view() {
        $blockType = \BlockType::getByHandle('gond_read_more_trial_bottom');
        $this->set('blockType', $blockType);
    }

    public function getBlockUID($b = null)
    {
        // Gets a unique bID for block $b.
        // Doesn't work with $this->getBlockObject() because that function returns a generic block with no proxyBlock.

        if ($b==null) return null;

        $proxyBlock = $b->getProxyBlock();
        return $proxyBlock? $proxyBlock->getBlockID() : $b->bID;
    }

    public function getRowClasses($rowHTML)
    {
        // Return CSS element classNames, if any.
        if ($rowHTML == null) return "";
        if (preg_match("/class\h*=\h*[\"|'](.+)[\"|']/U", $rowHTML, $matches)) {
            return $matches[1];
        }
        return "";
    }
}
