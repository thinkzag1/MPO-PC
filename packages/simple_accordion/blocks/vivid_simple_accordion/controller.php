<?php 
namespace Concrete\Package\SimpleAccordion\Block\VividSimpleAccordion;
use \Concrete\Core\Block\BlockController;
use Loader;

class Controller extends BlockController
{
    protected $btTable = 'btVividSimpleAccordion';
    protected $btInterfaceWidth = "700";
    protected $btWrapperClass = 'ccm-ui';
    protected $btInterfaceHeight = "465";

    public function getBlockTypeDescription()
    {
        return t("Add Collapsible Content to your Site");
    }

    public function getBlockTypeName()
    {
        return t("Simple Accordion");
    }

    public function add()
    {
        $this->requireAsset('redactor');
    }

    public function edit()
    {
        $this->requireAsset('redactor');
        $db = Loader::db();
        $items = $db->GetAll('SELECT * from btVividSimpleAccordionItem WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        $this->set('items', $items);
    }

    public function view()
    {
        $db = Loader::db();
        $items = $db->GetAll('SELECT * from btVividSimpleAccordionItem WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        $this->set('items', $items);
        $this->requireAsset('css', 'font-awesome');
        switch($this->semantic){
            case "h2":
                $openTag = "<h2 class='panel-title'>";
                $closeTag = "</h2>";
                break;    
            case "h3":
                $openTag = "<h3 class='panel-title'>";
                $closeTag = "</h3>";
                break;
            case "h4":
                $openTag = "<h4 class='panel-title'>";
                $closeTag = "</h4>";
                break;
            case "paragraph":
                $openTag = "<p class='panel-title'>";
                $closeTag = "</p>";
                break;
            case "span":
                $openTag = "<span class='panel-title'>";
                $closeTag = "</span>";
                break;
        }
        $this->set("openTag",$openTag);
        $this->set("closeTag",$closeTag);
    }

    public function duplicate($newBID) {
        parent::duplicate($newBID);
        $db = Loader::db();
        $v = array($this->bID);
        $q = 'select * from btVividSimpleAccordionItem where bID = ?';
        $r = $db->query($q, $v);
        while ($row = $r->FetchRow()) {
            $db->execute('INSERT INTO btVividSimpleAccordionItem (bID, title, description, state, sortOrder) values(?,?,?,?,?)',
                array(
                    $newBID,
                    $args['title'][$i],
                    $args['description'][$i],
                    $args['state'][$i],
                    $args['sortOrder'][$i]
                )
            );
        }
    }

    public function delete()
    {
        $db = Loader::db();
        $db->delete('btVividSimpleAccordionItem', array('bID' => $this->bID));
        parent::delete();
    }

    public function save($args)
    {
        $db = Loader::db();
        $db->execute('DELETE from btVividSimpleAccordionItem WHERE bID = ?', array($this->bID));
        $count = count($args['sortOrder']);
        $i = 0;
        parent::save($args);
        while ($i < $count) {
            $db->execute('INSERT INTO btVividSimpleAccordionItem (bID, title, description, state, sortOrder) values(?,?,?,?,?)',
                array(
                    $this->bID,
                    $args['title'][$i],
                    $args['description'][$i],
                    $args['state'][$i],
                    $args['sortOrder'][$i]
                )
            );
            $i++;
        }
        $blockObject = $this->getBlockObject();
        if (is_object($blockObject)) {
            $blockObject->setCustomTemplate($args['framework']);
        }
    }
    

}