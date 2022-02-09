<?php
namespace Concrete\Package\WhaleParallaxArea\Controller\SinglePage\Dashboard\Files;

use Core;
use Loader;
use File;
use User;
use UserList;
use Group;
use Package;
use stdClass;
use URL;
Use Block;
use Database;
use Config;
use lessc;
use Less_Parser;
use Less_Cache;
use Less_Tree_Rule;
use Asset;
use AssetList;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Concrete\Core\Legacy\DatabaseItemList;

defined('C5_EXECUTE') or die("Access Denied.");

class NodesList extends DatabaseItemList {
    public function __construct() {
    }
    public function setQuery($query) {
        $this->query = $query . ' ';
    }
    public function getQuery() {
        return $this->query;
    }
}

class WhaleParallaxArea extends DashboardPageController {

    public $id = 0; //default area id (for add)
    public $fID = 0; //file id

    //options
    public $bgColor = '';
    public $bgPositionX = 50; // %
    public $bgPositionY = 50; // %

    public $paddingTop = 120;
    public $paddingRight = 0;
    public $paddingBottom = 120;
    public $paddingLeft = 0;

    public $paddingTopMob = 50;
    public $paddingRightMob = 0;
    public $paddingBottomMob = 50;
    public $paddingLeftMob = 0;

    public $bgRepeats = array();
    public $bgRepeat = 'no-repeat';
    public $bgSizes = array();
    public $bgSize = 'auto';

    public $factor = 0.5; 
    public $types = array();
    public $type = 'background'; 
    public $directions = array();
    public $direction = 'vertical'; 

    public $fullscreen = 0; 

    public $contentPositionXs = array();
    public $contentPositionX = '';
    public $contentPositionYs = array();
    public $contentPositionY = '';

    public function on_start()
    {
        $this->db = Loader::db();
        //$this->db->debug = true;
        $this->error = Loader::helper('validation/error');
        $this->permission = (int)Config::get('whale_parallax_area.permission');

        $this->optionsObj = array();
        //$this->optionsJs = '';

        $this->bgRepeats = array('no-repeat'=>t('No Repeat'), 'repeat'=>t('Repeat'), 'repeat-x'=>t('Repeat X'), 'repeat-y'=>t('Repeat Y'));
        $this->bgSizes = array('auto'=>t('Auto'), 'cover'=>t('Cover'));

        $this->types = array('background'=>t('Background'), 'foreground'=>t('Foreground'));
        $this->directions = array('vertical'=>t('Vertical'), 'horizontal'=>t('Horizontal'));

        $this->contentPositionXs = array(''=>t('Default'), 'center'=>t('Center'), 'left'=>t('Left'), 'right'=>t('Right'));
        $this->contentPositionYs = array(''=>t('Default'), 'middle'=>t('Middle'), 'top'=>t('Top'), 'bottom'=>t('Bottom'));
    }

    public function getJavaScriptStrings()
    {
        return array(
            'confirm-delete' => t('Are you sure?')
        );
    }

    function view()
    {
        $this->prepareOptions();
        $this->loadResources();

        $query = "SELECT *  FROM whaleParallaxArea";
        $l = new NodesList();
        $l->setQuery($query);

        //set filters if user serach something:
        //keyword
        if ($_REQUEST['fKeywords'] != false && strlen($_REQUEST['fKeywords'])>0) {
            $val = trim($_REQUEST['fKeywords']);
            $q = sprintf( "(id='%s')", $val);
            $l->filter(false, $q);
        }

        //permission check:
        switch ($this->permission) {
            case 0:
                break;
            case 1:
                $u = new User();
                if (!$u->isSuperUser()) {
                    $uID = $u->getUserID();
                    $q = sprintf( "(fmUID=%d)", $uID);
                    $l->filter(false, $q);
                }
                break;
            case 2:
                $u = new User();
                $uID = $u->getUserID();
                $q = sprintf( "(fmUID=%d)", $uID);
                $l->filter(false, $q);
                break;
        }

        //permission check:
        switch ($this->permission) {
            case 0:
                break;
            case 1:
                $u = new User();
                if (!$u->isSuperUser()) {
                    $uID = $u->getUserID();
                    $q = sprintf( "(fmUID=%d)", $uID);
                    $l->filter(false, $q);
                }
                break;
            case 2:
                $u = new User();
                $uID = $u->getUserID();
                $q = sprintf( "(fmUID=%d)", $uID);
                $l->filter(false, $q);
                break;
        }

        $l->sortByMultiple("id DESC");
        $l->setItemsPerPage(20);
        $list = $l->getPage();

        $this->set('list', $list);
        $this->set('l', $l);
    }

    //load resource (js, css)
    private function loadResources()
    {
        $pkg = Package::getByHandle('whale_parallax_area');

        $al = AssetList::getInstance(); 
        
        $al->register( 'css', 'dashboard.wpa', 'css/dashboard.wpa.css' , array('position' => Asset::ASSET_POSITION_FOOTER), $pkg ); 
        $al->register( 'javascript', 'dashboard.wpa', 'js/dashboard.wpa.js' , array('position' => Asset::ASSET_POSITION_FOOTER), $pkg ); 

        $this->requireAsset('css', 'dashboard.wpa');
        $this->requireAsset('javascript', 'dashboard.wpa');
    }

    public function add()
    {
        $this->includeUIElements();
        $this->prepareOptions();
        $this->loadResources();

        //set form ini values
        $this->prepareFormValues(0);

        if ($this->isPost()) {
            $this->_validate();
            if (!$this->error->has()) {
                $this->_save();
                $this->redirect('/dashboard/files/whale_parallax_area/', 'record_added');
            }
        }
    }

    public function update()
    {
        $this->edit($this->post('id'));

        if ($this->isPost()) {
            $this->_validate();
            if (!$this->error->has()) {
                $this->_save($this->post('id'));
                if ($this->post('ccm-update')) $this->redirect('/dashboard/files/whale_parallax_area/', 'record_updated');
            }
        }
    }

    public function edit($id) {
        $this->includeUIElements();
        $this->prepareOptions();
        $this->loadResources();
        //set form ini values
        $this->prepareFormValues($id);
    }

    private function _validate()
    {
        $hvs = Loader::helper('validation/strings');
        //$hvn = Loader::helper('validation/numbers');
        //$hvf = Loader::helper('validation/form');

        //$this->error->add('error1');

        if ($this->error->has()) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function _save($id=0)
    {
        $jh = Loader::helper('json');

        //get uId, date
        $u = new User();
        $uID = $u->getUserID();
        $dh = Loader::helper('date');
        $date = $dh->getOverridableNow();

        //regenerate json string
        $this->options = $jh->encode($this->optionsObj);

        if ($id==0){
            $data_insert = array(
                                (int)$this->fID,
                                $this->options,
                                $date, $date,
                                $uID, $uID
                            );
            $this->db->Execute("INSERT INTO whaleParallaxArea(
                                    fID, options,
                                    dateAdded, dateModified, fmUID, lmUID
                                )
                                VALUES
                                (
                                    ?, ?, 
                                    ?, ?, ? , ?
                                )",
                    $data_insert
                    );
        } else {
            $data_update = array(
                                (int)$this->fID,
                                $this->options,
                                $date,
                                $uID,
                                $id
                            );
            //print_r($data_update);die;
            $this->db->Execute("UPDATE whaleParallaxArea SET
                                   fID=?, options=?, dateModified=?, lmUID=?
                                   WHERE id=?
                                   LIMIT 1
                               ",
                               $data_update
                               );
        }
        
        $this->_generateCSSFile();
        $this->_generateJSFile();

        $this->set('message', t('Record updated. You should clear the cache, if it is enabled.'));

    }

    public function record_added()
    {
        $this->set('message', t('Record added.'));
        $this->view();
    }

    public function record_updated()
    {
        $this->set('message', t('Record updated. You should clear the cache, if it is enabled.'));
        $this->view();
    }

    //prepare ini values for forms
    protected function prepareFormValues($id=0)
    {
        $jh = Loader::helper('json');

        if ($id==0){//set for add (default values)

            $this->fID = $this->fID;

            //default values
            $this->optionsObj = new stdClass();

            //options
            $this->optionsObj->bgColor = $this->bgColor;
            $this->optionsObj->bgPositionX = (int)$this->bgPositionX;
            $this->optionsObj->bgPositionY = (int)$this->bgPositionY;
            $this->optionsObj->paddingTop = (int)$this->paddingTop;
            $this->optionsObj->paddingRight = (int)$this->paddingRight;
            $this->optionsObj->paddingBottom = (int)$this->paddingBottom;
            $this->optionsObj->paddingLeft = (int)$this->paddingLeft;
            $this->optionsObj->paddingTopMob = (int)$this->paddingTopMob;
            $this->optionsObj->paddingRightMob = (int)$this->paddingRightMob;
            $this->optionsObj->paddingBottomMob = (int)$this->paddingBottomMob;
            $this->optionsObj->paddingLeftMob = (int)$this->paddingLeftMob;
            $this->optionsObj->bgRepeat = $this->bgRepeat;
            $this->optionsObj->bgSize = $this->bgSize;
            $this->optionsObj->factor = $this->factor;
            $this->optionsObj->type = $this->type;
            $this->optionsObj->direction = $this->direction;
            $this->optionsObj->fullscreen = $this->fullscreen;
            $this->optionsObj->contentPositionX = $this->contentPositionX;
            $this->optionsObj->contentPositionY = $this->contentPositionY;

            $this->options = $jh->encode($this->optionsObj);

        } else {

            //get record from db:
            $q = sprintf("SELECT * FROM `whaleParallaxArea` WHERE id=%d", $id);
            //permission check:
            switch ($this->permission) {
                case 0:
                    break;
                case 1:
                    $u = new User();
                    if (!$u->isSuperUser()) {
                        $uID = $u->getUserID();
                        $q .= sprintf(" AND fmUID=%d", $uID);
                    }
                    break;
                case 2:
                    $u = new User();
                    $uID = $u->getUserID();
                    $q .= sprintf(" AND fmUID=%d", $uID);
                    break;
            }
            $q .= sprintf(" LIMIT 1");

            $rslt = $this->db->Execute($q);//var_dump($rslt);die;

            if ($rslt->numRows()<1) $this->redirect('/dashboard/files/whale_parallax_area/');
            $s = (object)$rslt->fetchRow();
            //print_r($s);die;

            //put them into variables:
            $this->id = $s->id;
            $this->fID = $s->fID;

            //get file object and add to array for use at view:
            $this->fObj = 0;
            if (isset($this->fID)){
                $f = File::getByID($this->fID);
                $this->fObj = $f->getApprovedVersion();
                //var_dump($this->fObj);die;
            }

            $this->options = $s->options;
            $this->optionsObj = $jh->decode($s->options);
            //print_r($this);die;

        }

        //on post:
        if ($this->isPost()) {

            //print_r($_POST);die;
            $this->fID = $this->post('fID');

            //options
            $this->optionsObj->bgColor = $this->post('bgColor');
            $this->optionsObj->bgPositionX = (int)$this->post('bgPositionX');
            $this->optionsObj->bgPositionY = (int)$this->post('bgPositionY');
            $this->optionsObj->paddingTop = (int)$this->post('paddingTop');
            $this->optionsObj->paddingRight = (int)$this->post('paddingRight');
            $this->optionsObj->paddingBottom = (int)$this->post('paddingBottom');
            $this->optionsObj->paddingLeft = (int)$this->post('paddingLeft');
            $this->optionsObj->paddingTopMob = (int)$this->post('paddingTopMob');
            $this->optionsObj->paddingRightMob = (int)$this->post('paddingRightMob');
            $this->optionsObj->paddingBottomMob = (int)$this->post('paddingBottomMob');
            $this->optionsObj->paddingLeftMob = (int)$this->post('paddingLeftMob');
            $this->optionsObj->bgRepeat = $this->post('bgRepeat');
            $this->optionsObj->bgSize = $this->post('bgSize');
            $this->optionsObj->factor = number_format($this->post('factor'), 1);
            $this->optionsObj->type = $this->post('type');
            $this->optionsObj->direction = $this->post('direction');
            $this->optionsObj->fullscreen = $this->post('fullscreen');
            $this->optionsObj->contentPositionX = $this->post('contentPositionX');
            $this->optionsObj->contentPositionY = (int)$this->post('contentPositionY');

            $this->options = $jh->encode($this->optionsObj);

        }

        $record = (object)array(
                      "id" => $this->id,
                      "fID" => $this->fID,
                      "fObj" => $this->fObj,
                      "optionsObj" => $this->optionsObj,
                      "options" => $this->options,
                     );
        $this->set('record', $record);
        //print_r($_POST);
        //print_r($record);die;

    }

    //prepare data for combo,...
    protected function prepareOptions()
    {
        //begin:get combo values from db & lang file (for filter section)

        //combo values
        $this->set('bgRepeats', $this->bgRepeats);
        $this->set('bgSizes', $this->bgSizes);
        $this->set('types', $this->types);
        $this->set('directions', $this->directions);
        $this->set('contentPositionXs', $this->contentPositionXs);
        $this->set('contentPositionYs', $this->contentPositionYs);
    }

    public function mass_update()
    {
        $action = "";
        if (isset($_REQUEST['ccm-mass-update']) && $_REQUEST['ccm-mass-update']==t("Delete")){ $action = "delete";}
        if (isset($_REQUEST['ccm-mass-update']) && $_REQUEST['ccm-mass-update']==t("Duplicate")){ $action = "duplicate";}

        $selected_items = '0';
        if ($_REQUEST['cb_items']!=false && is_array($_REQUEST['cb_items'])) {

            //$selected_items = array();
            $affected_rows = 0;
            foreach($_REQUEST['cb_items'] as $value){
                $id_to_update = (int)$value;
                switch ($action) {
                    case 'delete':
                        $affected_rows += $this->delete_record($id_to_update);
                        break;
                    case 'duplicate':
                        $affected_rows += $this->duplicate_record($id_to_update);
                        break;
                }
            }

            //output msg
            switch ($action) {
                case 'delete':
                    $this->set('message', $msg = t("%s Records Deleted.", $affected_rows));
                    break;
                case 'duplicate':
                    $this->set('message', $msg = t("%s Records Duplicated.", $affected_rows));
                    break;
            }

        } else {
            $this->set('message', $msg = t("No records selected."));
        }

        $this->_generateCSSFile();
        $this->_generateJSFile();

        $this->view();
    }

    private function delete_record($id)
    {
        //delete record at `whaleParallaxArea`:
        $query = sprintf("DELETE FROM `whaleParallaxArea` WHERE 1=1 AND id ='%d'", $id);
        $r = $this->db->prepare($query);
        $rslt = $this->db->execute($r);
        if ($rslt) return 1;
        return 0;
    }

    private function duplicate_record($id)
    {
        $query = sprintf("INSERT INTO `whaleParallaxArea` (`fID`, `options`, `dateAdded`, `dateModified`, `fmUID`, `lmUID`)
                            SELECT `fID`, `options`, `dateAdded`, `dateModified`, `fmUID`, `lmUID` FROM `whaleParallaxArea` WHERE id='%d'", $id);
        $r = $this->db->prepare($query);
        $rslt = $this->db->execute($r);
        if ($rslt) return 1;
        return 0;
    }

    /**
     * Loads required assets and variables when in edit or add mode.
     * Called by edit() and add()
     */
    private function includeUIElements()
    {
        $this->requireAsset('core/file-manager');
        $this->requireAsset('core/sitemap');
        //$this->requireAsset('redactor');
    }

    private function _generateCSSFile()
    {

        $cssContent = 
'/*
*  Whale Parallax Area
*/
'       ;

        $jh = Core::make('helper/json');
        $this->options = $jh->encode($this->optionsObj);

        $pathInput = DIR_PACKAGES.'/whale_parallax_area/css/';
        $pathOutput = DIR_FILES_UPLOADED_STANDARD.'/cache//whale_parallax_area/';
        if (!is_dir($pathOutput)) mkdir($pathOutput, 0777, true);

        $lessFile = $pathInput.'whale-parallax-area.less';
        $lessFileContent = file_get_contents($lessFile);//echo $lessFileContent;die;

        //first get records:
        $q = sprintf("SELECT * FROM `whaleParallaxArea` WHERE 1");
        $rslt = $this->db->fetchAll($q); //dd($rslt);die;

        //json to array
        foreach ($rslt as $key => $value) $rslt[$key]['options'] = $jh->decode($value['options']);
        
        foreach ($rslt as $key => $value) {
            $imageSrc = '';
            $fID = (int)$value['fID'];
            if ($fID>0){
                $imageFile = File::getByID($fID);
                $imageSrc = $imageFile->getRelativePath();

            }
            //var_dump($imgSrc);die;///kwsoft/files/4114/6048/1685/owl-slide-02.jpg

            $lessVar= array(
                    "class" => "wpa-".$value['id'],
                    "bgColor" => ($value["options"]->bgColor) ? $value["options"]->bgColor : 'none',
                    "bgRepeat" => ($value["options"]->bgRepeat) ? $value["options"]->bgRepeat : 'no-repeat',
                    "bgSize" => ($value["options"]->bgSize) ? $value["options"]->bgSize : 'auto',
                    "bgPositionX" => (int)$value["options"]->bgPositionX."%",
                    "bgPositionY" => (int)$value["options"]->bgPositionY."%",
                    
                    "paddingTop" => (int)$value["options"]->paddingTop."px",
                    "paddingRight" => (int)$value["options"]->paddingRight."px",
                    "paddingBottom" => (int)$value["options"]->paddingBottom."px",
                    "paddingLeft" => (int)$value["options"]->paddingLeft."px",
                    
                    "paddingTopMob" => (int)$value["options"]->paddingTopMob."px",
                    "paddingRightMob" => (int)$value["options"]->paddingRightMob."px",
                    "paddingBottomMob" => (int)$value["options"]->paddingBottomMob."px",
                    "paddingLeftMob" => (int)$value["options"]->paddingLeftMob."px",

                    //"bgImageSrc" => $imageSrc 
                    "bgImageSrc" => "x1" //not possible to send image path to less?
                );
            //print_r($lessVar);die;
            
            $options = array( 'compress'=>false );
            $parser = new Less_Parser($options);
            $parser->parseFile( $lessFile );
            $parser->ModifyVars( $lessVar );
            $cssContent .= $parser->getCss(); //echo $cssContent;die;

            $cssContent = str_replace("x1", $imageSrc, $cssContent);
        }

        $cssFile = $pathOutput.'whale-parallax-area.css';
        $fh = Loader::helper('file');
        $fh->clear($cssFile);
        $fh->append($cssFile, $cssContent);
    }    

    private function _generateJSFile()
    {

        $jsContent = 
'/*
*  Whale Parallax Area
*/
'       ;

        $jh = Core::make('helper/json');

        $pathInput = DIR_PACKAGES.'/whale_parallax_area/js/';
        $pathOutput = DIR_FILES_UPLOADED_STANDARD.'/cache//whale_parallax_area/';
        if (!is_dir($pathOutput)) mkdir($pathOutput, 0777, true);

        $jsFile = $pathInput.'jquery.paroller.min.js';
        $jsFileContent = file_get_contents($jsFile);//echo $lessFileContent;die;
        $jsFileOutput = $pathOutput.'jquery.paroller.min.with.initializer.js';

        //first get records:
        $q = sprintf("SELECT * FROM `whaleParallaxArea` WHERE 1");
        $rslt = $this->db->fetchAll($q); //dd($rslt);
        //json to array
        foreach ($rslt as $key => $value) $rslt[$key]['options'] = $jh->decode($value['options']);
        //print_r($rslt);die;
        
        $jsInitializers = "";
        $jsInitializerTemplate = "$('%s').paroller({factor:%g, type:'%s', direction:'%s'});";
        
        foreach ($rslt as $key => $value) {
            
            $jsInitializers .= sprintf(
                $jsInitializerTemplate, 
                ".wpa-".$value['id'],
                $value["options"]->factor, 
                $value["options"]->type, 
                $value["options"]->direction 
            );

        }

        //echo $jsInitializers;die;
        $fh = Loader::helper('file');
        $fh->clear($jsFileOutput);
        $fh->append($jsFileOutput, $jsFileContent.$jsInitializers);
    }    

}
