<?php 
/**
 * @author      shahroq <shahroq \at\ yahoo.com>
 * @copyright   Copyright (c) 2016 shahroq
 * http://concrete5.killerwhalesoft.com/addons/
 */
namespace Concrete\Package\WhaleOwlCarousel\Controller\SinglePage\Dashboard\Files;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Concrete\Core\Legacy\DatabaseItemList;
use Loader;
use File;
use User;
use UserList;
use Group;
use Package;
use stdClass;
use URL;
Use Block;
use Config;

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

class WhaleOwlCarousel extends DashboardPageController {

    public $id = 0; //default carousel id (for add)

    public $carouselName = 'OWLCarousel-'; //default carousel name prefix

    public $carouselPlugins = array();
    public $carouselPlugin = 'owl'; //default value

    public $carouselThemes = array();
    public $carouselTheme = 'owl'; //default value

    /*carousel options: saves in `options` with json format*/
    public $showTitle = true;
    public $showDescription = true;
    public $showExtraText = false;
    public $singleItem = false;
    public $fullscreen = false;
    public $bgPosition = 70; //in %
    public $responsiveCaption = true;
    public $itemsNum = 5;
    public $itemsDesktopX = 1199;
    public $itemsDesktopY = 4;
    public $itemsDesktopSmallX = 979;
    public $itemsDesktopSmallY = 3;
    public $itemsTabletX = 768;
    public $itemsTabletY = 2;
    public $itemsTabletSmallX = false;
    public $itemsTabletSmallY = false;
    public $itemsMobileX = 479;
    public $itemsMobileY = 2;
    //public $itemsCustomX = false;
    //public $itemsCustomY = false;

    public $itemsScaleUp = false;
    public $slideSpeed = 200;
    public $paginationSpeed = 800;
    public $rewindSpeed = 1000;
    public $autoPlay = 0;
    public $progressBar = 0;
    public $progressBarHeight = 4;
    public $progressBarBGColor = '';
    public $progressBarFillColor = '';
    public $stopOnHover = false;
    public $navigation = false;
    public $navigationTextNext = 'Next';
    public $navigationTextPrev = 'Prev';
    public $navigationPosition = 25; //in px, pos: outside, neg: inside
    public $navigationSize = 20; //in px 
    public $navigationThickness = 2; //in px 
    public $navigationOpacity = 1; //0-1
    public $navigationColor = '#666666'; 
    public $rewindNav = true;
    public $scrollPerPage = false;
    public $pagination = true;
    public $paginationPosition = 10; //in px, pos: outside, neg: inside
    public $paginationSize = 12; //in px (width/height, border radius)
    public $paginationColor = ''; 
    public $paginationNumbers = false;
    public $responsive = true;
    public $responsiveRefreshRate = 200;
    //public $responsiveBaseWidth = 'window';
    //public $baseClass = 'owl-carouse';
    public $lazyLoad = false;
    public $lazyFollow = true;
    //public $lazyEffect = 'fade';
    public $autoHeight = false;
    public $dragBeforeAnimFinish = true;
    public $mouseDrag = true;
    public $touchDrag = true;
    public $transitionStyles = array();
    public $transitionStyle = false;
    public $random = false;

    //design options
    public $carouselBgColor = '';
    public $itemsBgColor = '';
    public $fontColor = '';
    public $itemsPaddingTop = 0;
    public $itemsPaddingRight = 0;
    public $itemsPaddingBottom = 0;
    public $itemsPaddingLeft = 0;
    public $carouselCss = '';
    public $itemsCss = '';
    public $itemsChildrenCss = '';
    public $itemsImagesCss = '';
    public $itemsTitlesCss = '';
    public $itemsDescriptionsCss = '';
    public $itemsExtraTextsCss = '';
    public $styles = '';
    public $embedFont = '';

    //button
    public $buttonDefaultBGColor = '#ffffff';
    public $buttonDefaultBGOpacity = 0;
    public $buttonDefaultFontColor = '#ffffff';
    public $buttonDefaultBorderWidth = 1;
    public $buttonDefaultBorderColor = '#ffffff';
    public $buttonDefaultBorderRadius = 0;
    public $buttonDefaultPaddingVer = 10;
    public $buttonDefaultPaddingHor = 35;
    public $buttonHoverBGColor = '#ffffff';
    public $buttonHoverBGOpacity = 1;
    public $buttonHoverFontColor = '#000000';
    public $buttonHoverBorderWidth = 1;
    public $buttonHoverBorderColor = '#ffffff';
    public $buttonHoverBorderRadius = 0;
    public $buttonHoverPaddingVer = 10;
    public $buttonHoverPaddingHor = 35;
    public $buttonCss = '';

    //animation
    public $animationDisable = 0;
    public $animationEffect = '';
    public $animationEffects = array();
    public $animationDuration = 1000;
    public $animationDelay = 0;

    //lightbox
    public $lightbox = false;
    public $lightboxShowTitle = false;
    public $lightboxShowDescription = false;
    public $lightboxEffects = array();
    public $lightboxEffect = 'fade';
    public $lightboxThemes = array();
    public $lightboxTheme = 'default';
    public $lightboxKeyboardNav = true;
    public $lightboxClickOverlayToClose = true;
    public $lightboxTouchWipe = true;

    /*Items (slides): save in `items` with json format*/
    public $itemImageID = 0;
    public $captionPositions = array();
    public $captionPosition = '';
    public $captionAligns = array();
    public $captionAlign = 'center';
    public $captionPadding = 1; //%
    public $captionAnimation = '';
    public $itemHeader = '';
    public $itemHeaderTypes = array();
    public $itemHeaderType = 'h3'; //default value
    public $itemDescription = '';
    public $itemUrlTypes = array();
    public $itemUrlType = ''; //default value
    public $itemUrlNewWindowOptions = array();
    public $itemUrlNewWindow = 0; //default value
    public $itemUrlExternal = '';
    public $itemUrlInternal = '';
    public $itemImageWidth = ''; //px
    public $itemImageHeight = ''; //px
    public $itemBgColor = '';
    public $itemActive = 1;

    public $optionsObj = '';
    public $options = '{}'; //keep json string

    public $itemsObj = '';
    public $items = '{}'; //keep json string

    public function on_start()
    {
        $this->db = Loader::db();
        //$this->db->debug = true;
        $this->error = Loader::helper('validation/error');
        $this->permission = (int)Config::get('whale_owl_carousel.permission');

        $this->carouselPlugins = array('owl'=>t('OWL'));
        $this->carouselThemes = array('owl'=>t('Owl'));
        
        $this->animationEffects = array(
                                        ''=>t('[ None ]') ,
                                        'bounce'=>t('bounce'), 'flash'=>t('flash'), 'pulse'=>t('pulse'), 'rubberBand'=>t('rubberBand'), 'shake'=>t('shake'), 'swing'=>t('swing'),
                                        'tada'=>t('tada'), 'wobble'=>t('wobble'), 'jello'=>t('jello'), 'bounceIn'=>t('bounceIn'), 'bounceInDown'=>t('bounceInDown'), 
                                        'bounceInLeft'=>t('bounceInLeft'), 'bounceInRight'=>t('bounceInRight'), 'bounceInUp'=>t('bounceInUp'), 'bounceOut'=>t('bounceOut'), 
                                        'bounceOutDown'=>t('bounceOutDown'), 'bounceOutLeft'=>t('bounceOutLeft'), 'bounceOutRight'=>t('bounceOutRight'), 'bounceOutUp'=>t('bounceOutUp'), 
                                        'fadeIn'=>t('fadeIn'), 'fadeInDown'=>t('fadeInDown'), 'fadeInDownBig'=>t('fadeInDownBig'), 'fadeInLeft'=>t('fadeInLeft'), 
                                        'fadeInLeftBig'=>t('fadeInLeftBig'), 'fadeInRight'=>t('fadeInRight'), 'fadeInRightBig'=>t('fadeInRightBig'), 'fadeInUp'=>t('fadeInUp'), 
                                        'fadeInUpBig'=>t('fadeInUpBig'), 'fadeOut'=>t('fadeOut'), 'fadeOutDown'=>t('fadeOutDown'), 'fadeOutDownBig'=>t('fadeOutDownBig'), 
                                        'fadeOutLeft'=>t('fadeOutLeft'), 'fadeOutLeftBig'=>t('fadeOutLeftBig'), 'fadeOutRight'=>t('fadeOutRight'), 'fadeOutRightBig'=>t('fadeOutRightBig'), 
                                        'fadeOutUp'=>t('fadeOutUp'), 'fadeOutUpBig'=>t('fadeOutUpBig'), 'flip'=>t('flip'), 'flipInX'=>t('flipInX'), 'flipInY'=>t('flipInY'), 
                                        'flipOutX'=>t('flipOutX'), 'flipOutY'=>t('flipOutY'), 'lightSpeedIn'=>t('lightSpeedIn'), 'lightSpeedOut'=>t('lightSpeedOut'), 'rotateIn'=>t('rotateIn'), 
                                        'rotateInDownLeft'=>t('rotateInDownLeft'), 'rotateInDownRight'=>t('rotateInDownRight'), 'rotateInUpLeft'=>t('rotateInUpLeft'), 
                                        'rotateInUpRight'=>t('rotateInUpRight'), 'rotateOut'=>t('rotateOut'), 'rotateOutDownLeft'=>t('rotateOutDownLeft'), 
                                        'rotateOutDownRight'=>t('rotateOutDownRight'), 'rotateOutUpLeft'=>t('rotateOutUpLeft'), 'rotateOutUpRight'=>t('rotateOutUpRight'), 
                                        'slideInUp'=>t('slideInUp'), 'slideInDown'=>t('slideInDown'), 'slideInLeft'=>t('slideInLeft'), 'slideInRight'=>t('slideInRight'), 
                                        'slideOutUp'=>t('slideOutUp'), 'slideOutDown'=>t('slideOutDown'), 'slideOutLeft'=>t('slideOutLeft'), 'slideOutRight'=>t('slideOutRight'), 
                                        'zoomIn'=>t('zoomIn'), 'zoomInDown'=>t('zoomInDown'), 'zoomInLeft'=>t('zoomInLeft'), 'zoomInRight'=>t('zoomInRight'), 'zoomInUp'=>t('zoomInUp'), 
                                        'zoomOut'=>t('zoomOut'), 'zoomOutDown'=>t('zoomOutDown'), 'zoomOutLeft'=>t('zoomOutLeft'), 'zoomOutRight'=>t('zoomOutRight'), 'zoomOutUp'=>t('zoomOutUp'), 
                                        'hinge'=>t('hinge'), 'rollIn'=>t('rollIn'), 'rollOut'=>t('rollOut')
                                        );


        $this->captionPositions = array(
                                     ''=>t('Bellow Image') ,
                                     'tl'=>t('Top Left'), 'tc'=>t('Top Center'), 'tr'=>t('Top Right'), 
                                     'ml'=>t('Middle Left'), 'mc'=>t('Middle Center'), 'mr'=>t('Middle Right'), 
                                     'bl'=>t('Bottom Left'), 'bc'=>t('Bottom Center'), 'br'=>t('Bottom Right'), 
                                     );
        $this->captionAligns = array('center'=>t('Center'), 'left'=>t('Left'), 'right'=>'Right');
        $this->itemHeaderTypes = array('h1'=>'h1', 'h2'=>'h2', 'h3'=>'h3', 'h4'=>'h4', 'h5'=>'h5', 'h6'=>'h6');
        $this->itemUrlWrappers = array('slide'=>t('Slide'), 'button'=>t('Button'));
        $this->itemUrlLabel = t('Go');
        $this->itemUrlTypes = array('external'=>t('External'), 'internal'=>t('Internal'));
        $this->itemUrlNewWindowOptions = array(0=>t('No'), 1=>t('Yes'));
        $this->transitionStyles = array(''=>t('None'), 'fade'=>t('Fade'), 'backSlide'=>t('Back Slide'), 'goDown'=>t('Go Down'), 'fadeUp'=>t('Fade Up'));

        $this->lightboxEffects = array('fade'=>t('Fade'), 'fadeScale'=>t('Fade Scale'), 'slideLeft'=>t('Slide Left'), 'slideRight'=>t('Slide Right'), 'slideUp'=>t('Slide Up'), 'slideDown'=>t('Slide Down'), 'fall'=>t('Fall'));
        $this->lightboxThemes = array('default'=>t('Default'));

        //css templates
        $this->itemsImagesCssTemplates = array();
        $this->itemsImagesCssTemplates['c'] = array(
                                                    'title'=>t('C'),
                                                    'tooltip'=>t('Clear'), 
                                                    'css'=>''
            );
        $this->itemsImagesCssTemplates['rounded'] = array(
                                                    'title'=>t('Rounded'),
                                                    'css'=>'border-radius: 6px;'
            );
        $this->itemsImagesCssTemplates['circle'] = array(
                                                    'title'=>t('Circle'),
                                                    'css'=>'border-radius: 50%;'
            );
        $this->itemsImagesCssTemplates['thumbnail-1'] = array(
                                                    'title'=>t('Thumbnail 1'),
                                                    'css'=>'border: 3px solid #FFFFFF; box-shadow: 0 0 1px 0 rgba(0, 0, 0, 0.8);'
            );

        $this->itemsTitlesCssTemplates = array();
        $this->itemsTitlesCssTemplates['c'] = array(
                                                    'title'=>t('C'),
                                                    'tooltip'=>t('Clear'), 
                                                    'css'=>''
            );
        $this->itemsTitlesCssTemplates['bold'] = array(
                                                    'title'=>t('Bold'),
                                                    'css'=>'font-weight: bold;'
            );
        $this->itemsTitlesCssTemplates['italic'] = array(
                                                    'title'=>t('Italic'),
                                                    'css'=>'font-style: italic;'
            );
        $this->itemsTitlesCssTemplates['uppercase'] = array(
                                                    'title'=>t('Uppercase'),
                                                    'css'=>'text-transform: uppercase;'
            );
        $this->itemsTitlesCssTemplates['font'] = array(
                                                    'title'=>t('Font'),
                                                    'css'=>'font-family: Arial; font-size:12px;font-weight:bold;'
            );

        $this->itemsDescriptionsCssTemplates = array();
        $this->itemsDescriptionsCssTemplates['c'] = array(
                                                    'title'=>t('C'),
                                                    'tooltip'=>t('Clear'), 
                                                    'css'=>''
            );
        $this->itemsDescriptionsCssTemplates['bold'] = array(
                                                    'title'=>t('Bold'),
                                                    'css'=>'font-weight: bold;'
            );
        $this->itemsDescriptionsCssTemplates['italic'] = array(
                                                    'title'=>t('Italic'),
                                                    'css'=>'font-style: italic;'
            );
        $this->itemsDescriptionsCssTemplates['uppercase'] = array(
                                                    'title'=>t('Uppercase'),
                                                    'css'=>'text-transform: uppercase;'
            );
        $this->itemsDescriptionsCssTemplates['box'] = array(
                                                    'title'=>t('Box'),
                                                    'css'=>'border-radius: 10px; padding: 10px; background: #f5f5f5;'
            );
        $this->itemsDescriptionsCssTemplates['font'] = array(
                                                    'title'=>t('Font'),
                                                    'css'=>'font-family: Arial; font-size:12px;font-weight:bold;'
            );

        $this->itemsExtraTextsCssTemplates = array();
        $this->itemsExtraTextsCssTemplates['c'] = array(
                                                    'title'=>t('C'),
                                                    'tooltip'=>t('Clear'), 
                                                    'css'=>''
            );
        $this->itemsExtraTextsCssTemplates['bold'] = array(
                                                    'title'=>t('Bold'),
                                                    'css'=>'font-weight: bold;'
            );
        $this->itemsExtraTextsCssTemplates['italic'] = array(
                                                    'title'=>t('Italic'),
                                                    'css'=>'font-style: italic;'
            );
        $this->itemsExtraTextsCssTemplates['italic'] = array(
                                                    'title'=>t('Italic'),
                                                    'css'=>'font-style: italic;'
            );
        $this->itemsExtraTextsCssTemplates['font'] = array(
                                                    'title'=>t('Font'),
                                                    'css'=>'font-family: Arial; font-size:12px;font-weight:bold;'
            );

        $this->stylesTemplates = array();
        $this->stylesTemplates['c'] = array(
                                                    'title'=>t('C'),
                                                    'tooltip'=>t('Clear'), 
                                                    'css'=>''
            );
        $this->stylesTemplates['description_bubble'] = array(
                                                    'title'=>t('Description Bubble'),
                                                    'css'=>".item-description{\r\nposition: relative;\r\npadding: 10px;\r\nbackground: #f5f5f5;\r\n-webkit-border-radius: 10px;\r\n-moz-border-radius: 10px;\r\nborder-radius: 10px;\r\n}\r\n.item-description:after{\r\ncontent: '';\r\nposition: absolute;\r\nborder-style: solid;\r\nborder-width: 0 20px 15px;\r\nborder-color: #f5f5f5 transparent;\r\ndisplay: block;\r\nwidth: 0;\r\nz-index: 1;\r\nmargin-left: -20px;\r\ntop: -15px;\r\nleft: 50%;\r\n}"
            );
        $this->stylesTemplates['description_bubble_bordered'] = array(
                                                    'title'=>t('Description Bubble Bordered'),
                                                    'css'=>".item-description{\r\nposition: relative;\r\npadding: 10px;\r\nbackground: #ffffff;\r\n-webkit-border-radius: 10px;\r\n-moz-border-radius: 10px;\r\nborder-radius: 10px;\r\nborder: #f0f0f0 solid 5px;\r\n}\r\n.item-description:after{\r\ncontent: '';\r\nposition: absolute;\r\nborder-style: solid;\r\nborder-width: 0 15px 15px;\r\nborder-color: #ffffff transparent;\r\ndisplay: block;\r\nwidth: 0;\r\nz-index: 1;\r\nmargin-left: -15px;\r\ntop: -15px;\r\nleft: 50%;\r\n}\r\n.item-description:before{\r\ncontent: '';\r\nposition: absolute;\r\nborder-style: solid;\r\nborder-width: 0 19px 19px;\r\nborder-color: #f0f0f0 transparent;\r\ndisplay: block;\r\nwidth: 0;\r\nz-index: 0;\r\nmargin-left: -19px;\r\ntop: -24px;\r\nleft: 50%;\r\n}"
            );

        //embed fonts templates
        $this->embedFontTemplates = array();
        $this->embedFontTemplates['c'] = array(
                                                'title'=>t('C'), 
                                                'tooltip'=>t('Clear'), 
                                                'css'=>'');
        $this->embedFontTemplates['open-sans'] = array(
                                                    'title'=>t('Open Sans'),
                                                    'css'=>"<link href='//fonts.googleapis.com/css?family=Open+Sans:400,800' rel='stylesheet' type='text/css'>"
            );
        $this->embedFontTemplates['raleway'] = array(
                                                    'title'=>t('Raleway'),
                                                    'css'=>"<link href='//fonts.googleapis.com/css?family=Raleway:400,900,800,700,600,500,300,200,100' rel='stylesheet' type='text/css'>"
            );
        $this->embedFontTemplates['baskerville'] = array(
                                                    'title'=>t('Baskerville'),
                                                    'css'=>"<link href='//fonts.googleapis.com/css?family=Libre+Baskerville:400,400italic,700' rel='stylesheet' type='text/css'>"
            );
        $this->embedFontTemplates['roboto'] = array(
                                                    'title'=>t('Roboto'),
                                                    'css'=>"<link href='//fonts.googleapis.com/css?family=Roboto:400,100,400italic,700italic,700' rel='stylesheet' type='text/css'>"
            );

    }

    public function getJavaScriptStrings()
    {
        return array(
            'confirm-delete' => t('Deleting a carousel will remove all block instances using that carousel on all pages, are you sure?')
        );
    }

    function view()
    {
        $this->prepareOptions();
        $this->loadResources();

        $query = "SELECT id,carouselName,carouselPlugin,carouselTheme  FROM whaleOwlCarousel";
        $l = new NodesList();
        $l->setQuery($query);

        //set filters if user serach something:
        //keyword
        if ($_REQUEST['fKeywords'] != false && strlen($_REQUEST['fKeywords'])>0) {
            $val = trim($_REQUEST['fKeywords']);
            $q = sprintf( "(id='%s' OR carouselName LIKE '%%%s%%')", $val, $val);
            $l->filter(false, $q);
        }

        //permission check:
        switch ($this->permission) {
            case 0:
                break;
            case 1:
                $u = new User();
                if(!$u->isSuperUser()) {
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
        $uh = Loader::helper('concrete/urls');
        $hh = Loader::helper('html');
        //load resources:
        $pkg = Package::getByHandle('whale_owl_carousel');
        $uh->getPackageURL($pkg);

        //$v = View::getInstance();
        $this->addHeaderItem($hh->css('owl.dashboard.css','whale_owl_carousel'));
        $this->addFooterItem($hh->javascript('funcs.owl.dashboard.js','whale_owl_carousel'));
        $this->addHeaderItem($hh->css('animate/animate.min.css','whale_owl_carousel'));
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
                $this->redirect('/dashboard/files/whale_owl_carousel/', 'record_added');
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
                if($this->post('ccm-update')) $this->redirect('/dashboard/files/whale_owl_carousel/', 'record_updated');
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
        if (!$hvs->min($this->carouselName,1) || !$hvs->max($this->carouselName,255)) $this->error->add(t('Carousel Name is not valid.'));
        if (!array_key_exists($this->carouselTheme, $this->carouselThemes) || $this->carouselTheme=='none') $this->error->add(t('Select a Theme.'));

        if (!array_key_exists($this->optionsObj->lightboxEffect, $this->lightboxEffects) || $this->optionsObj->lightboxEffect=='none') $this->error->add(t('Select a Lightbox Effect.'));
        if (!array_key_exists($this->optionsObj->lightboxTheme, $this->lightboxThemes) || $this->optionsObj->lightboxTheme=='none') $this->error->add(t('Select a Lightbox Theme.'));

        if ($this->error->has()) {
            return FALSE;
        }else{
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

        //first remove some of extra values:
        foreach ((object)$this->itemsObj as $key => $value) {
            if(isset($this->itemsObj->{$key}->itemImageObj)) unset($this->itemsObj->{$key}->itemImageObj);
        }
        //regenerate json string
        $this->options = $jh->encode($this->optionsObj);
        $this->items = $jh->encode($this->itemsObj);

        if($id==0){
            $data_insert = array(
                                $this->carouselName, $this->carouselPlugin, $this->carouselTheme, $this->options, $this->items,
                                $date, $date, $uID, $uID
                            );
            $this->db->Execute("INSERT INTO whaleOwlCarousel(
                                    carouselName, carouselPlugin, carouselTheme, options, items,
                                    dateAdded, dateModified, fmUID, lmUID
                                )
                                VALUES
                                (
                                    ?, ?, ?, ?, ?,
                                    ?, ?, ? , ?
                                )",
                    $data_insert
                    );
        }else{
            $data_update = array(
                               $this->carouselName, $this->carouselPlugin, $this->carouselTheme, $this->options, $this->items, $date, $uID, $id
                               );
            //print_r($data_update);die;
            $this->db->Execute("UPDATE whaleOwlCarousel SET
                                   carouselName=?, carouselPlugin=?, carouselTheme=?, options=?, items=?, dateModified=?, lmUID=?
                                   WHERE id=?
                                   LIMIT 1
                               ",
                               $data_update
                               );
        }
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

        if($id==0){//set for add (default values)
            $this->carouselName = $this->carouselName.date('Ymd-Hi');
            //default values
            $this->optionsObj = new stdClass();
            $this->optionsObj->showTitle = $this->showTitle;
            $this->optionsObj->showDescription = $this->showDescription;
            $this->optionsObj->showExtraText = $this->showExtraText;
            $this->optionsObj->singleItem = $this->singleItem;
            $this->optionsObj->fullscreen = $this->fullscreen;
            $this->optionsObj->bgPosition = $this->bgPosition;
            $this->optionsObj->responsiveCaption = $this->responsiveCaption;
            $this->optionsObj->itemsNum = $this->itemsNum;
            $this->optionsObj->itemsDesktopX = $this->itemsDesktopX;
            $this->optionsObj->itemsDesktopY = $this->itemsDesktopY;
            $this->optionsObj->itemsDesktopSmallX = $this->itemsDesktopSmallX;
            $this->optionsObj->itemsDesktopSmallY = $this->itemsDesktopSmallY;
            $this->optionsObj->itemsTabletX = $this->itemsTabletX;
            $this->optionsObj->itemsTabletY = $this->itemsTabletY;
            $this->optionsObj->itemsTabletSmallX = $this->itemsTabletSmallX;
            $this->optionsObj->itemsTabletSmallY = $this->itemsTabletSmallY;
            $this->optionsObj->itemsMobileX = $this->itemsMobileX;
            $this->optionsObj->itemsMobileY = $this->itemsMobileY;
            $this->optionsObj->itemsCustomX = $this->itemsCustomX;
            $this->optionsObj->itemsCustomY = $this->itemsCustomY;
            $this->optionsObj->itemsScaleUp = $this->itemsScaleUp;
            $this->optionsObj->slideSpeed = $this->slideSpeed;
            $this->optionsObj->paginationSpeed = $this->paginationSpeed;
            $this->optionsObj->rewindSpeed = $this->rewindSpeed;
            $this->optionsObj->autoPlay = $this->autoPlay;
            $this->optionsObj->progressBar = $this->progressBar;
            $this->optionsObj->progressBarHeight = $this->progressBarHeight;
            $this->optionsObj->progressBarBGColor = $this->progressBarBGColor;
            $this->optionsObj->progressBarFillColor = $this->progressBarFillColor;
            $this->optionsObj->stopOnHover = $this->stopOnHover;
            $this->optionsObj->navigation = $this->navigation;
            $this->optionsObj->navigationTextNext = $this->navigationTextNext;
            $this->optionsObj->navigationTextPrev = $this->navigationTextPrev;
            $this->optionsObj->navigationPosition = $this->navigationPosition;
            $this->optionsObj->navigationSize = $this->navigationSize;
            $this->optionsObj->navigationThickness = $this->navigationThickness;
            $this->optionsObj->navigationOpacity = $this->navigationOpacity;
            $this->optionsObj->navigationColor = $this->navigationColor;
            $this->optionsObj->rewindNav = $this->rewindNav;
            $this->optionsObj->scrollPerPage = $this->scrollPerPage;
            $this->optionsObj->pagination = $this->pagination;
            $this->optionsObj->paginationPosition = $this->paginationPosition;
            $this->optionsObj->paginationSize = $this->paginationSize;
            $this->optionsObj->paginationColor = $this->paginationColor;
            $this->optionsObj->paginationNumbers = $this->paginationNumbers;
            $this->optionsObj->responsive = $this->responsive;
            $this->optionsObj->responsiveRefreshRate = $this->responsiveRefreshRate;
            $this->optionsObj->responsiveBaseWidth = $this->responsiveBaseWidth;
            $this->optionsObj->baseClass = $this->baseClass;
            $this->optionsObj->lazyLoad = $this->lazyLoad;
            $this->optionsObj->lazyFollow = $this->lazyFollow;
            //$this->optionsObj->lazyEffect = $this->lazyEffect;
            $this->optionsObj->autoHeight = $this->autoHeight;
            $this->optionsObj->dragBeforeAnimFinish = $this->dragBeforeAnimFinish;
            $this->optionsObj->mouseDrag = $this->mouseDrag;
            $this->optionsObj->touchDrag = $this->touchDrag;
            $this->optionsObj->transitionStyle = $this->transitionStyle;
            $this->optionsObj->random = $this->random;

            $this->optionsObj->carouselBgColor = $this->carouselBgColor;
            $this->optionsObj->itemsBgColor = $this->itemsBgColor;
            $this->optionsObj->fontColor = $this->fontColor;
            $this->optionsObj->itemsPaddingTop = $this->itemsPaddingTop;
            $this->optionsObj->itemsPaddingRight = $this->itemsPaddingRight;
            $this->optionsObj->itemsPaddingBottom = $this->itemsPaddingBottom;
            $this->optionsObj->itemsPaddingLeft = $this->itemsPaddingLeft;
            $this->optionsObj->carouselCss = $this->carouselCss;
            $this->optionsObj->itemsCss = $this->itemsCss;
            $this->optionsObj->itemsChildrenCss = $this->itemsChildrenCss;
            $this->optionsObj->itemsImagesCss = $this->itemsImagesCss;
            $this->optionsObj->itemsTitlesCss = $this->itemsTitlesCss;
            $this->optionsObj->itemsDescriptionsCss = $this->itemsDescriptionsCss;
            $this->optionsObj->itemsExtraTextsCss = $this->itemsExtraTextsCss;
            $this->optionsObj->styles = $this->styles;
            $this->optionsObj->embedFont = $this->embedFont;

            $this->optionsObj->buttonDefaultBGColor = $this->buttonDefaultBGColor;
            $this->optionsObj->buttonDefaultBGOpacity = $this->buttonDefaultBGOpacity;
            $this->optionsObj->buttonDefaultFontColor = $this->buttonDefaultFontColor;
            $this->optionsObj->buttonDefaultBorderWidth = $this->buttonDefaultBorderWidth;
            $this->optionsObj->buttonDefaultBorderColor = $this->buttonDefaultBorderColor;
            $this->optionsObj->buttonDefaultBorderRadius = $this->buttonDefaultBorderRadius;
            $this->optionsObj->buttonDefaultPaddingVer = $this->buttonDefaultPaddingVer;
            $this->optionsObj->buttonDefaultPaddingHor = $this->buttonDefaultPaddingHor;
            $this->optionsObj->buttonHoverBGColor = $this->buttonHoverBGColor;
            $this->optionsObj->buttonHoverBGOpacity = $this->buttonHoverBGOpacity;
            $this->optionsObj->buttonHoverFontColor = $this->buttonHoverFontColor;
            $this->optionsObj->buttonHoverBorderWidth = $this->buttonHoverBorderWidth;
            $this->optionsObj->buttonHoverBorderColor = $this->buttonHoverBorderColor;
            $this->optionsObj->buttonHoverBorderRadius = $this->buttonHoverBorderRadius;
            $this->optionsObj->buttonHoverPaddingVer = $this->buttonHoverPaddingVer;
            $this->optionsObj->buttonHoverPaddingHor = $this->buttonHoverPaddingHor;
            $this->optionsObj->buttonCss = $this->buttonCss;

            $this->optionsObj->animationDisable = $this->animationDisable;
            $this->optionsObj->animationEffect = $this->animationEffect;
            $this->optionsObj->animationDuration = $this->animationDuration;
            $this->optionsObj->animationDelay = $this->animationDelay;

            $this->optionsObj->lightbox = $this->lightbox;
            $this->optionsObj->lightboxShowTitle = $this->lightboxShowTitle;
            $this->optionsObj->lightboxShowDescription = $this->lightboxShowDescription;
            $this->optionsObj->lightboxEffect = $this->lightboxEffect;
            $this->optionsObj->lightboxTheme = $this->lightboxTheme;
            $this->optionsObj->lightboxKeyboardNav = $this->lightboxKeyboardNav;
            $this->optionsObj->lightboxClickOverlayToClose = $this->lightboxClickOverlayToClose;
            $this->optionsObj->lightboxTouchWipe = $this->lightboxTouchWipe;

            $this->options = $jh->encode($this->optionsObj);

            //prepare items (json):
            $this->itemsObj = new stdClass();
            $this->items = $jh->encode($this->itemsObj);

        }else{
            //get record from db:
            $q = sprintf("SELECT * FROM `whaleOwlCarousel` WHERE id=%d", $id);
            //permission check:
            switch ($this->permission) {
                case 0:
                    break;
                case 1:
                    $u = new User();
                    if(!$u->isSuperUser()) {
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

            if($rslt->numRows()<1) $this->redirect('/dashboard/files/whale_owl_carousel/');
            $s = (object)$rslt->fetchRow();

            //put them into variables:
            $this->id = $s->id;
            $this->carouselName = $s->carouselName;
            $this->carouselPlugin = $s->carouselPlugin;
            $this->carouselTheme = $s->carouselTheme;
            $this->options = $s->options;
            $this->optionsObj = $jh->decode($s->options);
            //print_r($this->optionsObj);

            //get file object and add to array for use at view:
            //items
            $this->itemsObj = $jh->decode($s->items);
            $i = 0;
            foreach ((object)$this->itemsObj as $key => $value) {
                //set an id for each item
                $this->itemsObj->{$key}->itemID = $i;

                //get file object and add to array for use at view:
                /*
                $this->itemsObj->{$key}->itemImageObj = 0;
                if(isset($this->itemsObj->{$key}->itemImageID)){
                    $f = File::getByID($this->itemsObj->{$key}->itemImageID);
                    $this->itemsObj->{$key}->itemImageObj = $f->getApprovedVersion();
                }
                */
                $i++;
            }

            //make content safe (escape)
            foreach ((object)$this->itemsObj as $key => $value) {
                $this->itemsObj->{$key}->itemDescription = $this->remove_carriage($this->itemsObj->{$key}->itemDescription);
            }
            //print_r($this->itemsObj);die;
        }

        //on post:
        if ($this->isPost()) {
            $this->carouselName = $_POST['carouselName'];
            $this->carouselPlugin = $_POST['carouselPlugin'];
            $this->carouselTheme = $_POST['carouselTheme'];

            //options
            $this->optionsObj->showTitle = (int)$_POST['showTitle'];
            $this->optionsObj->showDescription = (int)$_POST['showDescription'];
            $this->optionsObj->showExtraText = (int)$_POST['showExtraText'];
            $this->optionsObj->singleItem = (int)$_POST['singleItem'];
            $this->optionsObj->fullscreen = (int)$_POST['fullscreen'];
            $this->optionsObj->bgPosition = (int)$_POST['bgPosition'];
            $this->optionsObj->responsiveCaption = (int)$_POST['responsiveCaption'];
            $this->optionsObj->itemsNum = (int)$_POST['itemsNum'];
            $this->optionsObj->itemsDesktopX = (int)$_POST['itemsDesktopX'];
            $this->optionsObj->itemsDesktopY = (int)$_POST['itemsDesktopY'];
            $this->optionsObj->itemsDesktopSmallX = (int)$_POST['itemsDesktopSmallX'];
            $this->optionsObj->itemsDesktopSmallY = (int)$_POST['itemsDesktopSmallY'];
            $this->optionsObj->itemsTabletX = (int)$_POST['itemsTabletX'];
            $this->optionsObj->itemsTabletY = (int)$_POST['itemsTabletY'];
            $this->optionsObj->itemsTabletSmallX = (int)$_POST['itemsTabletSmallX'];
            $this->optionsObj->itemsTabletSmallY = (int)$_POST['itemsTabletSmallY'];
            $this->optionsObj->itemsMobileX = (int)$_POST['itemsMobileX'];
            $this->optionsObj->itemsMobileY = (int)$_POST['itemsMobileY'];
            $this->optionsObj->itemsCustomX = (int)$_POST['itemsCustomX'];
            $this->optionsObj->itemsCustomY = (int)$_POST['itemsCustomY'];
            $this->optionsObj->itemsScaleUp = (int)$_POST['itemsScaleUp'];
            $this->optionsObj->slideSpeed = (int)$_POST['slideSpeed'];
            $this->optionsObj->paginationSpeed = $_POST['paginationSpeed'];
            $this->optionsObj->rewindSpeed = (int)$_POST['rewindSpeed'];
            $this->optionsObj->autoPlay = (int)$_POST['autoPlay'];
            $this->optionsObj->progressBar = (int)$_POST['progressBar'];
            $this->optionsObj->progressBarHeight = (int)$_POST['progressBarHeight'];
            $this->optionsObj->progressBarBGColor = $_POST['progressBarBGColor'];
            $this->optionsObj->progressBarFillColor = $_POST['progressBarFillColor'];
            $this->optionsObj->stopOnHover = (int)$_POST['stopOnHover'];
            $this->optionsObj->navigation = (int)$_POST['navigation'];
            $this->optionsObj->navigationTextNext = $_POST['navigationTextNext'];
            $this->optionsObj->navigationTextPrev = $_POST['navigationTextPrev'];
            $this->optionsObj->navigationPosition = (int)$_POST['navigationPosition'];
            $this->optionsObj->navigationSize = (int)$_POST['navigationSize'];
            $this->optionsObj->navigationThickness = (int)$_POST['navigationThickness'];
            $this->optionsObj->navigationOpacity = (float)$_POST['navigationOpacity'];
            $this->optionsObj->navigationColor = $_POST['navigationColor'];
            $this->optionsObj->rewindNav = (int)$_POST['rewindNav'];
            $this->optionsObj->scrollPerPage = (int)$_POST['scrollPerPage'];
            $this->optionsObj->pagination = (int)$_POST['pagination'];
            $this->optionsObj->paginationPosition = (int)$_POST['paginationPosition'];
            $this->optionsObj->paginationSize = (int)$_POST['paginationSize'];
            $this->optionsObj->paginationColor = $_POST['paginationColor'];
            $this->optionsObj->paginationNumbers = (int)$_POST['paginationNumbers'];
            $this->optionsObj->responsive = (int)$_POST['responsive'];
            $this->optionsObj->responsiveRefreshRate = (int)$_POST['responsiveRefreshRate'];
            $this->optionsObj->responsiveBaseWidth = $_POST['responsiveBaseWidth'];
            $this->optionsObj->baseClass = $_POST['baseClass'];
            $this->optionsObj->lazyLoad = (int)$_POST['lazyLoad'];
            $this->optionsObj->lazyFollow = (int)$_POST['lazyFollow'];
            //$this->optionsObj->lazyEffect = $_POST['lazyEffect'];
            $this->optionsObj->autoHeight = (int)$_POST['autoHeight'];
            $this->optionsObj->dragBeforeAnimFinish = (int)$_POST['dragBeforeAnimFinish'];
            $this->optionsObj->mouseDrag = (int)$_POST['mouseDrag'];
            $this->optionsObj->touchDrag = (int)$_POST['touchDrag'];
            $this->optionsObj->transitionStyle = $_POST['transitionStyle'];
            $this->optionsObj->random = (int)$_POST['random'];
            //design options
            $this->optionsObj->carouselBgColor = $_POST['carouselBgColor'];
            $this->optionsObj->itemsBgColor = $_POST['itemsBgColor'];
            $this->optionsObj->fontColor = $_POST['fontColor'];
            $this->optionsObj->itemsPaddingTop = (int)$_POST['itemsPaddingTop'];
            $this->optionsObj->itemsPaddingRight = (int)$_POST['itemsPaddingRight'];
            $this->optionsObj->itemsPaddingBottom = (int)$_POST['itemsPaddingBottom'];
            $this->optionsObj->itemsPaddingLeft = (int)$_POST['itemsPaddingLeft'];
            $this->optionsObj->carouselCss = $_POST['carouselCss'];
            $this->optionsObj->itemsCss = $_POST['itemsCss'];
            $this->optionsObj->itemsChildrenCss = $_POST['itemsChildrenCss'];
            $this->optionsObj->itemsImagesCss = $_POST['itemsImagesCss'];
            $this->optionsObj->itemsTitlesCss = $_POST['itemsTitlesCss'];
            $this->optionsObj->itemsDescriptionsCss = $_POST['itemsDescriptionsCss'];
            $this->optionsObj->itemsExtraTextsCss = $_POST['itemsExtraTextsCss'];
            $this->optionsObj->styles = $_POST['styles'];
            $this->optionsObj->embedFont = $_POST['embedFont'];

            $this->optionsObj->buttonDefaultBGColor = $_POST['buttonDefaultBGColor'];
            $this->optionsObj->buttonDefaultBGOpacity = $_POST['buttonDefaultBGOpacity'];
            $this->optionsObj->buttonDefaultFontColor = $_POST['buttonDefaultFontColor'];
            $this->optionsObj->buttonDefaultBorderWidth = (int)$_POST['buttonDefaultBorderWidth'];
            $this->optionsObj->buttonDefaultBorderColor = $_POST['buttonDefaultBorderColor'];
            $this->optionsObj->buttonDefaultBorderRadius = (int)$_POST['buttonDefaultBorderRadius'];
            $this->optionsObj->buttonDefaultPaddingVer = (int)$_POST['buttonDefaultPaddingVer'];
            $this->optionsObj->buttonDefaultPaddingHor = (int)$_POST['buttonDefaultPaddingHor'];
            $this->optionsObj->buttonHoverBGColor = $_POST['buttonHoverBGColor'];
            $this->optionsObj->buttonHoverBGOpacity = $_POST['buttonHoverBGOpacity'];
            $this->optionsObj->buttonHoverFontColor = $_POST['buttonHoverFontColor'];
            $this->optionsObj->buttonHoverBorderWidth = (int)$_POST['buttonHoverBorderWidth'];
            $this->optionsObj->buttonHoverBorderColor = $_POST['buttonHoverBorderColor'];
            $this->optionsObj->buttonHoverBorderRadius = (int)$_POST['buttonHoverBorderRadius'];
            $this->optionsObj->buttonHoverPaddingVer = (int)$_POST['buttonHoverPaddingVer'];
            $this->optionsObj->buttonHoverPaddingHor = (int)$_POST['buttonHoverPaddingHor'];
            $this->optionsObj->buttonCss = $_POST['buttonCss'];

            $this->optionsObj->animationDisable = (int)$_POST['animationDisable'];
            $this->optionsObj->animationEffect = $_POST['animationEffect'];
            $this->optionsObj->animationDuration = (int)$_POST['animationDuration'];
            $this->optionsObj->animationDelay = (int)$_POST['animationDelay'];

            $this->optionsObj->lightbox = (int)$_POST['lightbox'];
            $this->optionsObj->lightboxShowTitle = (int)$_POST['lightboxShowTitle'];
            $this->optionsObj->lightboxShowDescription = (int)$_POST['lightboxShowDescription'];
            $this->optionsObj->lightboxEffect = $_POST['lightboxEffect'];
            $this->optionsObj->lightboxTheme = $_POST['lightboxTheme'];
            $this->optionsObj->lightboxKeyboardNav = (int)$_POST['lightboxKeyboardNav'];
            $this->optionsObj->lightboxClickOverlayToClose = (int)$_POST['lightboxClickOverlayToClose'];
            $this->optionsObj->lightboxTouchWipe = (int)$_POST['lightboxTouchWipe'];

            $this->options = $jh->encode($this->optionsObj);

            //items
            $i = 0;
            $this->itemsObj = new stdClass();
            if(isset($_POST['itemID'])){
            foreach ($_POST['itemID'] as $key => $value) {
                $this->itemsObj->{$i} = new stdClass();
                $this->itemsObj->{$i}->itemID = $i;
                $this->itemsObj->{$i}->itemImageID = $_POST['itemImageID'][$key];
                $this->itemsObj->{$i}->captionPosition = $_POST['captionPosition'][$key];
                $this->itemsObj->{$i}->captionAlign = $_POST['captionAlign'][$key];
                $this->itemsObj->{$i}->captionPadding = (int)$_POST['captionPadding'][$key];
                $this->itemsObj->{$i}->captionAnimation = $_POST['captionAnimation'][$key];
                $this->itemsObj->{$i}->itemHeader = $_POST['itemHeader'][$key];
                $this->itemsObj->{$i}->itemHeaderType = $_POST['itemHeaderType'][$key];
                $this->itemsObj->{$i}->itemDescription = $this->remove_carriage($_POST['itemDescription'][$key]);
                $this->itemsObj->{$i}->itemExtraText = $_POST['itemExtraText'][$key];
                $this->itemsObj->{$i}->itemUrlWrapper = $_POST['itemUrlWrapper'][$key];
                $this->itemsObj->{$i}->itemUrlLabel = $_POST['itemUrlLabel'][$key];
                $this->itemsObj->{$i}->itemUrlType = $_POST['itemUrlType'][$key];
                $this->itemsObj->{$i}->itemUrlNewWindow = $_POST['itemUrlNewWindow'][$key];
                $this->itemsObj->{$i}->itemUrlExternal = $_POST['itemUrlExternal'][$key];
                $this->itemsObj->{$i}->itemUrlInternal = $_POST['itemUrlInternal'][$key];
                $this->itemsObj->{$i}->itemImageWidth = (int)$_POST['itemImageWidth'][$key];
                $this->itemsObj->{$i}->itemImageHeight = (int)$_POST['itemImageHeight'][$key];
                $this->itemsObj->{$i}->itemBgColor = $this->validate_hex_color($_POST['itemBgColor'][$key]);
                //$this->itemsObj->{$i}->itemActive = $_POST['itemActive'][$key];
                $this->itemsObj->{$i}->itemActive = in_array($i, (array)$_POST['itemActive'])?true:false;

                //get file object and add to array for use at view:
                $this->itemsObj->{$key}->itemImageObj = 0;
                if(isset($this->itemsObj->{$i}->itemImageID) && $this->itemsObj->{$i}->itemImageID){
                    $f = File::getByID($this->itemsObj->{$i}->itemImageID);
                    $this->itemsObj->{$i}->itemImageObj = $f;//->getApprovedVersion();
                }

                $i++;

            }
            }
            //it shows 'Array' instead of string value if unset it
            //unset($_POST['itemID']);
            unset($_POST['captionPosition']);
            unset($_POST['captionAlign']);
            unset($_POST['captionPadding']);
            unset($_POST['captionAnimation']);
            unset($_POST['itemHeader']);
            unset($_POST['itemHeaderType']);
            unset($_POST['itemDescription']);
            unset($_POST['itemExtraText']);
            unset($_POST['itemUrlWrapper']);
            unset($_POST['itemUrlLabel']);
            unset($_POST['itemUrlType']);
            unset($_POST['itemUrlNewWindow']);
            unset($_POST['itemUrlExternal']);
            unset($_POST['itemUrlInternal']);
            unset($_POST['itemImageWidth']);
            unset($_POST['itemImageHeight']);
            unset($_POST['itemBgColor']);
            unset($_POST['itemActive']);

            $this->items = $jh->encode($this->itemsObj);
            //print_r($this->items);die;
        }

        //prepare item for tmp (json):
        $this->itemsTmpObj = new stdClass();
        $this->itemsTmpObj->itemID = "tmp";
        $this->itemsTmpObj->itemImageID = $this->itemImageID;
        $this->itemsTmpObj->captionPosition = $this->captionPosition;
        $this->itemsTmpObj->captionAlign = $this->captionAlign;
        $this->itemsTmpObj->captionPadding = $this->captionPadding;
        $this->itemsTmpObj->captionAnimation = $this->captionAnimation;
        $this->itemsTmpObj->itemHeader = $this->itemHeader;
        $this->itemsTmpObj->itemHeaderType = $this->itemHeaderType;
        $this->itemsTmpObj->itemDescription = $this->itemDescription;
        $this->itemsTmpObj->itemExtraText = $this->itemExtraText;
        $this->itemsTmpObj->itemUrlWrapper = $this->itemUrlWrapper;
        $this->itemsTmpObj->itemUrlLabel = $this->itemUrlLabel;
        $this->itemsTmpObj->itemUrlType = $this->itemUrlType;
        $this->itemsTmpObj->itemUrlNewWindow = $this->itemUrlNewWindow;
        $this->itemsTmpObj->itemUrlExternal = $this->itemUrlExternal;
        $this->itemsTmpObj->itemUrlInternal = $this->itemUrlInternal;
        $this->itemsTmpObj->itemImageWidth = $this->itemImageWidth;
        $this->itemsTmpObj->itemImageHeight = $this->itemImageHeight;
        $this->itemsTmpObj->itemBgColor = $this->itemBgColor;
        $this->itemsTmpObj->itemActive = $this->itemActive;

        $this->itemsTmp = $jh->encode($this->itemsTmpObj);

        $record = (object)array(
                      "id" => $this->id,
                      "carouselName" => $this->carouselName,
                      "carouselPlugin" => $this->carouselPlugin,
                      "carouselTheme" => $this->carouselTheme,
                      "optionsObj" => $this->optionsObj,
                      "options" => $this->options,
                      "itemsObj" => $this->itemsObj,
                      "items" => $this->items,
                      "itemsTmpObj" => $this->itemsTmpObj,
                      "itemsTmp" => $this->itemsTmp
                     );
        $this->set('record', $record);
        //print_r($record);die;
    }

    //prepare data for combo,...
    protected function prepareOptions()
    {
        $jh = Loader::helper('json');

        //begin:get combo values from db & lang file (for filter section)

        //combo values
        $this->set('carouselPlugins', $this->carouselPlugins);
        $this->set('carouselThemes', $this->carouselThemes);
        $this->set('animationEffects', $this->animationEffects);
        $this->set('animationEffectsJson', $jh->encode($this->animationEffects)); //for use at js template

        $this->set('captionPositions', $this->captionPositions);
        $this->set('captionPositionsJson', $jh->encode($this->captionPositions));
        $this->set('captionAligns', $this->captionAligns);
        $this->set('captionAlignsJson', $jh->encode($this->captionAligns));
        $this->set('itemHeaderTypes', $this->itemHeaderTypes);
        $this->set('itemUrlWrappers', $this->itemUrlWrappers);
        $this->set('itemUrlTypes', $this->itemUrlTypes);
        $this->set('itemUrlNewWindowOptions', $this->itemUrlNewWindowOptions);
        $this->set('transitionStyles', $this->transitionStyles);

        $this->set('lightboxEffects', $this->lightboxEffects);
        $this->set('lightboxThemes', $this->lightboxThemes);

        //templates:
        $this->set('itemsImagesCssTemplates', $this->itemsImagesCssTemplates);
        $this->set('itemsTitlesCssTemplates', $this->itemsTitlesCssTemplates);
        $this->set('itemsDescriptionsCssTemplates', $this->itemsDescriptionsCssTemplates);
        $this->set('itemsExtraTextsCssTemplates', $this->itemsExtraTextsCssTemplates);
        $this->set('stylesTemplates', $this->stylesTemplates);
        $this->set('embedFontTemplates', $this->embedFontTemplates);
    }

    public function mass_update()
    {
        $action = "";
        if(isset($_REQUEST['ccm-mass-update']) && $_REQUEST['ccm-mass-update']==t("Delete")){ $action = "delete";}
        if(isset($_REQUEST['ccm-mass-update']) && $_REQUEST['ccm-mass-update']==t("Duplicate")){ $action = "duplicate";}

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

        }else{
            $this->set('message', $msg = t("No records selected."));
        }
        $this->view();
    }

    private function delete_record($id)
    {
        //first delete all blocks that use this carousel:
        $rslt = $this->db->GetAll("SELECT `bID` FROM `btWhaleOwlCarousel` WHERE carouselID=?", $id);
        foreach($rslt as $row){
            $block = Block::getByID($row['bID']);
            $block->delete(true);
            $block->refreshCache();
        }
        //delete record at `whaleOwlCarousel`:
        $query = sprintf("DELETE FROM `whaleOwlCarousel` WHERE 1=1 AND id ='%d'", $id);
        $r = $this->db->prepare($query);
        $rslt = $this->db->execute($r);
        if($rslt) return 1;
        return 0;
    }

    private function duplicate_record($id)
    {
        $query = sprintf("INSERT INTO `whaleOwlCarousel` (`carouselName`,`carouselPlugin`,`carouselTheme`,`options`,`items`,`dateAdded`,`dateModified`,`fmUID`,`lmUID`)
                            SELECT CONCAT('Copy of ', `carouselName`),`carouselPlugin`,`carouselTheme`,`options`,`items`,`dateAdded`,`dateModified`,`fmUID`,`lmUID` FROM `whaleOwlCarousel` WHERE id='%s'", $id);
        $r = $this->db->prepare($query);
        $rslt = $this->db->execute($r);
        if($rslt) return 1;
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

    private function validate_hex_color($color) {
        if (preg_match('/^[a-f0-9]{6}$/i', $color)) {
            return $color;
        }else{
            return '';
        }
    }

    private function validate_css($css) {
    }

    private function remove_carriage($str)
    {
        //return $str;
        //return preg_replace('~[[:cntrl:]]~', '', $str);
        return trim(preg_replace('/\s\s+/', ' ', $str));
    }


}