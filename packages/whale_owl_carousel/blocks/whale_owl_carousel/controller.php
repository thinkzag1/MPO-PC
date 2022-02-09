<?php 
/**
 * @author 		shahroq <shahroq \at\ yahoo.com>
 * @copyright  	Copyright (c) 2016 shahroq
 * http://concrete5.killerwhalesoft.com/addons/
 */

namespace Concrete\Package\WhaleOwlCarousel\Block\WhaleOwlCarousel;
use Concrete\Core\Block\BlockController;
use Loader;
use Core;
use BlockType;
use File;
use FileSet;
use FileList;
use Concrete\Core\File\Type\Type as FileType;
use Package;
use stdClass;
use Page;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends BlockController
{

	protected $btTable = 'btWhaleOwlCarousel';
    protected $btExportTables = array('btWhaleOwlCarousel');
	protected $btInterfaceWidth = "450";
	protected $btInterfaceHeight = "250";
    protected $btWrapperClass = 'ccm-ui';
    protected $btDefaultSet = 'multimedia';
    protected $btIgnorePageThemeGridFrameworkContainer = true;

    public $carousel;
    public $carouselList = array(); //block editing UI

    /*carousel options: saves in `options` with json format*/
    /*default values*/
    /*theme*/
    public $carouselTheme = 'owl';
    public $carouselThemeFile = '/owl_themes/owl/owl-theme.css';
    public $carouselThemeClass = 'owl-theme';
    /*options*/
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
    public $itemsCustomX = false;
    public $itemsCustomY = false;

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
    public $paginationPosition = 10;
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
    public $transitionStyle = '';
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
    public $animationDuration = 1500;
    public $animationDelay = 0;

    //lightbox
    public $lightbox = false;
    public $lightboxShowTitle = false;
    public $lightboxShowDescription = false;
    public $lightboxEffect = 'fade';
    public $lightboxTheme = 'default';
    public $lightboxKeyboardNav = true;
    public $lightboxClickOverlayToClose = true;
    public $lightboxTouchWipe = true;

    /*items: saves in `items` with json format*/
    public $itemHeaderType = 'h3'; //default value

    public function getBlockTypeDescription()
    {
        return t("Whale OWL Carousel");
    }

    public function getBlockTypeName()
    {
        return t("OWL Carousel");
    }

    public function getJavaScriptStrings()
    {
        return array(
            'select-item' => t('Please select a carousel.')
        );
    }

	function __construct($obj = null)
    {
		parent::__construct($obj);
	}

	function on_page_view()
    {
	}

    //load resources (js, css)
    private function loadResourcesHeader()
    {
        $this->requireAsset('javascript', 'jquery');
    }

    private function loadResourcesFooter()
    {
        $hh = Loader::helper('html');
        $pkg = BlockType::getByHandle($this->btHandle)->getPackageHandle();

        //load resources:
        //general css
        $this->addFooterItem($hh->css('owl.carousel.css',$pkg));
        $this->addFooterItem($hh->javascript('owl.carousel.min.js',$pkg));
        //$this->addHeaderItem($hh->css('owl.carousel.full.css',$pkg)); //contains both of owl.carousel.css & owl.transitions.css

        //theme css
        $this->addFooterItem($hh->css($this->carousel->carouselThemeFile, $pkg));

        //include transition css file if it's enabled:
        if($this->carousel->optionsObj->transitionStyle!=''){
            $this->addFooterItem($hh->css('owl.transitions.css',$pkg));
        }

        //include nivo lightbox files if it's enabled:
        if($this->carousel->optionsObj->lightbox){
            $this->addFooterItem($hh->javascript('nivo-lightbox.min.js',$pkg));
            $this->addFooterItem($hh->css('nivo-lightbox.css',$pkg));
            $this->addFooterItem($hh->css('nivo_lightbox_themes/default/default.css',$pkg));
        }

        //include touch wipe files if it's enabled:
        if($this->carousel->optionsObj->lightboxTouchWipe){
            $this->addFooterItem($hh->javascript('jquery.touchwipe.min.js',$pkg));
        }

        //animate
        if(!(isset($this->carousel->optionsObj->animationDisable) && $this->carousel->optionsObj->animationDisable)){
            $this->addFooterItem($hh->css('animate/animate.min.css',$pkg));
        }

    }


	function view()
    {
        $this->loadResourcesHeader();
        $this->getCarouselInfo();

        //get block identifier based on current version:
        $block_identifier = $this->getBlockObject()->getProxyBlock() ? $this->getBlockObject()->getProxyBlock()->getInstance()->getIdentifier() : $this->getIdentifier();
        $lightbox_identifier = 'LIGHTBOX_'.time().'_'.rand ( 0 , 10000 );
        $this->carousel->containerID = $block_identifier;
        $this->carousel->lightboxID = $lightbox_identifier;


        $this->carousel->packageVersion = Package::getByHandle('whale_owl_carousel')->getPackageVersion();

        $this->prepareJS();
        $this->prepareCSS();

        $this->loadResourcesFooter();

        $this->set('carousel', $this->carousel);

	}

    private function getCarouselInfo()
    {

        $db = Loader::db();
        $jh = Loader::helper('json');
        $nh = Loader::helper('navigation');
        $im = Loader::helper('image');
        $rslt = $db->getRow("SELECT * FROM whaleOwlCarousel WHERE id=? LIMIT 1", array((int)$this->carouselID));
        //check if carousel with specified id exist?
        if (empty($rslt)) return;

        $this->carousel = (object)$rslt;

        //theme:
        $this->carousel->carouselThemeFile = sprintf('owl_themes/%s/%s-theme.css', $this->carousel->carouselTheme, $this->carousel->carouselTheme);
        $this->carousel->carouselThemeClass = $this->carousel->carouselTheme."-theme";

        //get options as json and parse them:
        $this->carousel->optionsObj = $jh->decode($this->carousel->options);

        unset($this->carousel->options); //do not need them
        $this->carousel->itemsObj = $jh->decode($this->carousel->items);
        unset($this->carousel->items); //do not need them

        //remove inactive items
        foreach((object)$this->carousel->itemsObj as $key=>$value){
        if($this->carousel->itemsObj->{$key}->itemActive!=1){
            unset($this->carousel->itemsObj->{$key});
        }
        }

        //lazyLoad support, it needs different image src tag,also a class to operate
        //Delays loading of images. Images outside of viewport wont be loaded before user scrolls to them. Great for mobile devices to speed up page loadings.
        //Img need special class class="lazyOwl" and path to image in data-src="":
        //<img class="lazyOwl" data-src="path-to-your-image">
        $this->carousel->image_src_tag = "src";
        $this->carousel->image_class = "";
        if($this->carousel->optionsObj->lazyLoad==1){
            $this->carousel->image_src_tag = "data-src";
            $this->carousel->image_class = "lazyOwl";
        }

        //get items images+links+check default header type
        foreach((object)$this->carousel->itemsObj as $key=>$value){
            //image
            $this->carousel->itemsObj->{$key}->itemImageID = (int)$this->carousel->itemsObj->{$key}->itemImageID;
            if($value->itemImageID>0){
                $f = File::getByID($value->itemImageID);
                $fv = $f->getApprovedVersion();

                //resize it if user wanted to change the dimension
                if($value->itemImageWidth==0) $this->carousel->itemsObj->{$key}->itemImageWidth=1000;
                if($value->itemImageHeight==0) $this->carousel->itemsObj->{$key}->itemImageHeight=1000;
                if($value->itemImageWidth!=1000 || $value->itemImageHeight!=1000){
                    $this->carousel->itemsObj->{$key}->itemImageSrc = $im->getThumbnail($f, $value->itemImageWidth, $value->itemImageHeight)->src;
                }else{
                    $this->carousel->itemsObj->{$key}->itemImageSrc = $fv->getRelativePath();
                }
                $this->carousel->itemsObj->{$key}->itemImageSrcOrg = $fv->getRelativePath();//original image, for using in light box
                $this->carousel->itemsObj->{$key}->itemImageTitle = (strlen($this->carousel->itemsObj->{$key}->itemHeader)>0)?
                    $this->carousel->itemsObj->{$key}->itemHeader:$fv->getTitle();
                $this->carousel->itemsObj->{$key}->itemImageDescription = (strlen($this->carousel->itemsObj->{$key}->itemDescription)>0)?
                    $this->carousel->itemsObj->{$key}->itemDescription:$fv->getDescription();

                //image title,description into lightbox title
                if($this->carousel->optionsObj->lightbox){
                    $this->carousel->itemsObj->{$key}->itemLightboxTitle = '';
                    if($this->carousel->optionsObj->lightboxShowTitle){
                        $this->carousel->itemsObj->{$key}->itemLightboxTitle .= $this->carousel->itemsObj->{$key}->itemImageTitle;
                    }
                    if($this->carousel->optionsObj->lightboxShowDescription){
                        if(strlen($this->carousel->itemsObj->{$key}->itemLightboxTitle)>0) $this->carousel->itemsObj->{$key}->itemLightboxTitle .= ": ";
                        $this->carousel->itemsObj->{$key}->itemLightboxTitle .= $this->carousel->itemsObj->{$key}->itemImageDescription;
                    }
                }

            }

            //prepare urls href:
            $this->carousel->itemsObj->{$key}->itemUrlHref = FALSE;
            if($value->itemUrlType=='internal' && (boolean)$value->itemUrlInternal){
                $page = Page::getByID((int)$value->itemUrlInternal);
                $this->carousel->itemsObj->{$key}->itemUrlHref = $nh->getCollectionURL($page);
            }elseif($value->itemUrlType=='external' && (boolean)$value->itemUrlExternal){
                $this->carousel->itemsObj->{$key}->itemUrlHref = $value->itemUrlExternal;
            }

            //prepare urls target:
            $this->carousel->itemsObj->{$key}->itemUrlTarget = '_self';
            if($value->itemUrlNewWindow==1){
                $this->carousel->itemsObj->{$key}->itemUrlTarget = '_blank';
            }

            //check header type
            if(strlen($value->itemHeaderType)!=2) $this->carousel->itemsObj->{$key}->itemHeaderType = $this->itemHeaderType;

            //caption class
            $this->carousel->itemsObj->{$key}->captionClass = '';
            if(strlen($value->captionPosition)>0)  $this->carousel->itemsObj->{$key}->captionClass = 'inside '.$value->captionPosition;
            //caption align
            $this->carousel->itemsObj->{$key}->captionClass .= ' '.$value->captionAlign;

            //animation effect based on global/each slide value
            $tmp = $this->carousel->optionsObj->animationEffect;
            if(isset($this->carousel->itemsObj->{$key}->captionAnimation) && $this->carousel->itemsObj->{$key}->captionAnimation!='') 
                $tmp = $this->carousel->itemsObj->{$key}->captionAnimation; 
            $this->carousel->itemsObj->{$key}->captionAnimation = $tmp;

        }
        //print_r($this->carousel);die;

        return;
    }

	function add()
    {
		$this->getCarouselList();
        $this->set('pageID', $this->pageID);
        $this->set('bID', $this->bID);
	}

	function edit()
    {
		$this->getCarouselList();
		$this->set('pageID', $this->pageID);
		$this->set('bID', $this->bID);
	}

    public function save($data)
    {
        $args['carouselID'] = (int)$data['carouselID'];
        parent::save($args);
    }

    private function getCarouselList()
    {
        $db = Loader::db();
        $this->carouselList = $db->Execute("SELECT id, carouselName FROM whaleOwlCarousel ORDER BY carouselName");

        foreach ($this->carouselList as $key => $value) $tmp[$key] = $value;
        $this->carouselList = $tmp;

        $tmp = array(0=>t("[ Select a Carousel ] "));
        foreach ($this->carouselList as $key => $value) $tmp[$value['id']] = $value['carouselName'];
        $this->carouselList = $tmp;


        $this->set('carouselList', $this->carouselList);
        return;
    }

    //prepare js options:
    private function prepareJS()
    {
        $js = '';
        $jh = Loader::helper('json');

        $carouselOptionsObj = new stdClass();

        //active class
        $carouselOptionsObj->addClassActive = true;

        //theme:
        if(isset($this->carousel->carouselTheme) && $this->carousel->carouselTheme!=$this->carouselTheme)
            $carouselOptionsObj->theme = $this->carousel->carouselThemeClass;
        //options
        if(isset($this->carousel->optionsObj->itemsNum) && $this->carousel->optionsObj->itemsNum!=$this->itemsNum)
            $carouselOptionsObj->items = $this->carousel->optionsObj->itemsNum;
        if(
            (isset($this->carousel->optionsObj->itemsDesktopX) && $this->carousel->optionsObj->itemsDesktopX!=$this->itemsDesktopX) ||
            (isset($this->carousel->optionsObj->itemsDesktopY) && $this->carousel->optionsObj->itemsDesktopY!=$this->itemsDesktopY)
           )
            $carouselOptionsObj->itemsDesktop = array($this->carousel->optionsObj->itemsDesktopX,$this->carousel->optionsObj->itemsDesktopY);
        if(
            (isset($this->carousel->optionsObj->itemsDesktopSmallX) && $this->carousel->optionsObj->itemsDesktopSmallX!=$this->itemsDesktopSmallX) ||
            (isset($this->carousel->optionsObj->itemsDesktopSmallY) && $this->carousel->optionsObj->itemsDesktopSmallY!=$this->itemsDesktopSmallY)
           )
            $carouselOptionsObj->itemsDesktopSmall = array($this->carousel->optionsObj->itemsDesktopSmallX,$this->carousel->optionsObj->itemsDesktopSmallY);
        if(
            (isset($this->carousel->optionsObj->itemsTabletX) && $this->carousel->optionsObj->itemsTabletX!=$this->itemsTabletX) ||
            (isset($this->carousel->optionsObj->itemsTabletY) && $this->carousel->optionsObj->itemsTabletY!=$this->itemsTabletY)
           )
            $carouselOptionsObj->itemsTablet = array($this->carousel->optionsObj->itemsTabletX,$this->carousel->optionsObj->itemsTabletY);
        if(
            (isset($this->carousel->optionsObj->itemsTabletSmallX) && $this->carousel->optionsObj->itemsTabletSmallX!=$this->itemsTabletSmallX) ||
            (isset($this->carousel->optionsObj->itemsTabletSmallY) && $this->carousel->optionsObj->itemsTabletSmallY!=$this->itemsTabletSmallY)
           )
            $carouselOptionsObj->itemsTabletSmall = array($this->carousel->optionsObj->itemsTabletSmallX,$this->carousel->optionsObj->itemsTabletSmallY);
        if(
            (isset($this->carousel->optionsObj->itemsMobileX) && $this->carousel->optionsObj->itemsMobileX!=$this->itemsMobileX) ||
            (isset($this->carousel->optionsObj->itemsMobileY) && $this->carousel->optionsObj->itemsMobileY!=$this->itemsMobileY)
           )
            $carouselOptionsObj->itemsMobile = array($this->carousel->optionsObj->itemsMobileX,$this->carousel->optionsObj->itemsMobileY);
        if(isset($this->carousel->optionsObj->singleItem) && $this->carousel->optionsObj->singleItem!=$this->singleItem)
            $carouselOptionsObj->singleItem = (boolean)$this->carousel->optionsObj->singleItem;
        if(isset($this->carousel->optionsObj->itemsScaleUp) && $this->carousel->optionsObj->itemsScaleUp!=$this->itemsScaleUp)
            $carouselOptionsObj->itemsScaleUp = (boolean)$this->carousel->optionsObj->itemsScaleUp;
        if(isset($this->carousel->optionsObj->slideSpeed) && $this->carousel->optionsObj->slideSpeed!=$this->slideSpeed)
            $carouselOptionsObj->slideSpeed = $this->carousel->optionsObj->slideSpeed;
        if(isset($this->carousel->optionsObj->paginationSpeed) && $this->carousel->optionsObj->paginationSpeed!=$this->paginationSpeed)
            $carouselOptionsObj->paginationSpeed = $this->carousel->optionsObj->paginationSpeed;
        if(isset($this->carousel->optionsObj->rewindSpeed) && $this->carousel->optionsObj->rewindSpeed!=$this->rewindSpeed)
            $carouselOptionsObj->rewindSpeed = $this->carousel->optionsObj->rewindSpeed;
        if(isset($this->carousel->optionsObj->autoPlay) && $this->carousel->optionsObj->autoPlay!=$this->autoPlay)
            $carouselOptionsObj->autoPlay = $this->carousel->optionsObj->autoPlay;
        if(isset($this->carousel->optionsObj->stopOnHover) && $this->carousel->optionsObj->stopOnHover!=$this->stopOnHover)
            $carouselOptionsObj->stopOnHover = (boolean)$this->carousel->optionsObj->stopOnHover;
        if(isset($this->carousel->optionsObj->navigation) && $this->carousel->optionsObj->navigation!=$this->navigation)
            $carouselOptionsObj->navigation = (boolean)$this->carousel->optionsObj->navigation;
        if(
            (isset($this->carousel->optionsObj->navigationTextNext) && $this->carousel->optionsObj->navigationTextNext!=$this->navigationTextNext) ||
            (isset($this->carousel->optionsObj->navigationTextPrev) && $this->carousel->optionsObj->navigationTextPrev!=$this->navigationTextPrev)
           )
            $carouselOptionsObj->navigationText = array($this->carousel->optionsObj->navigationTextNext,$this->carousel->optionsObj->navigationTextPrev);
        if(isset($this->carousel->optionsObj->rewindNav) && $this->carousel->optionsObj->rewindNav!=$this->rewindNav)
            $carouselOptionsObj->rewindNav = (boolean)$this->carousel->optionsObj->rewindNav;
        if(isset($this->carousel->optionsObj->scrollPerPage) && $this->carousel->optionsObj->scrollPerPage!=$this->scrollPerPage)
            $carouselOptionsObj->scrollPerPage = (boolean)$this->carousel->optionsObj->scrollPerPage;
        if(isset($this->carousel->optionsObj->pagination) && $this->carousel->optionsObj->pagination!=$this->pagination)
            $carouselOptionsObj->pagination = (boolean)$this->carousel->optionsObj->pagination;
        if(isset($this->carousel->optionsObj->paginationNumbers) && $this->carousel->optionsObj->paginationNumbers!=$this->paginationNumbers)
            $carouselOptionsObj->paginationNumbers = (boolean)$this->carousel->optionsObj->paginationNumbers;
        if(isset($this->carousel->optionsObj->responsive) && $this->carousel->optionsObj->responsive!=$this->responsive)
            $carouselOptionsObj->responsive = (boolean)$this->carousel->optionsObj->responsive;
        if(isset($this->carousel->optionsObj->responsiveRefreshRate) && $this->carousel->optionsObj->responsiveRefreshRate!=$this->responsiveRefreshRate)
            $carouselOptionsObj->responsiveRefreshRate = $this->carousel->optionsObj->responsiveRefreshRate;
        if(isset($this->carousel->optionsObj->lazyLoad) && $this->carousel->optionsObj->lazyLoad!=$this->lazyLoad)
            $carouselOptionsObj->lazyLoad = (boolean)$this->carousel->optionsObj->lazyLoad;
        if(isset($this->carousel->optionsObj->lazyFollow) && $this->carousel->optionsObj->lazyFollow!=$this->lazyFollow)
            $carouselOptionsObj->lazyFollow = (boolean)$this->carousel->optionsObj->lazyFollow;
        if(isset($this->carousel->optionsObj->autoHeight) && $this->carousel->optionsObj->autoHeight!=$this->autoHeight)
            $carouselOptionsObj->autoHeight = (boolean)$this->carousel->optionsObj->autoHeight;
        if(isset($this->carousel->optionsObj->dragBeforeAnimFinish) && $this->carousel->optionsObj->dragBeforeAnimFinish!=$this->dragBeforeAnimFinish)
            $carouselOptionsObj->dragBeforeAnimFinish = (boolean)$this->carousel->optionsObj->dragBeforeAnimFinish;
        if(isset($this->carousel->optionsObj->mouseDrag) && $this->carousel->optionsObj->mouseDrag!=$this->mouseDrag)
            $carouselOptionsObj->mouseDrag = (boolean)$this->carousel->optionsObj->mouseDrag;
        if(isset($this->carousel->optionsObj->touchDrag) && $this->carousel->optionsObj->touchDrag!=$this->touchDrag)
            $carouselOptionsObj->touchDrag = (boolean)$this->carousel->optionsObj->touchDrag;
        if(isset($this->carousel->optionsObj->transitionStyle) && $this->carousel->optionsObj->transitionStyle!=$this->transitionStyle)
            $carouselOptionsObj->transitionStyle = $this->carousel->optionsObj->transitionStyle;

        //prepare lightbox options
        $lightboxOptionsObj = new stdClass();
        if(isset($this->carousel->optionsObj->lightboxEffect) && $this->carousel->optionsObj->lightboxEffect!=$this->lightboxEffect)
            $lightboxOptionsObj->effect = $this->carousel->optionsObj->lightboxEffect;
        if(isset($this->carousel->optionsObj->lightboxtheme) && $this->carousel->optionsObj->lightboxtheme!=$this->lightboxtheme)
            $lightboxOptionsObj->theme = $this->carousel->optionsObj->lightboxtheme;
        if(isset($this->carousel->optionsObj->lightboxKeyboardNav) && $this->carousel->optionsObj->lightboxKeyboardNav!=$this->lightboxKeyboardNav)
            $lightboxOptionsObj->keyboardNav = (boolean)$this->carousel->optionsObj->lightboxKeyboardNav;
        if(isset($this->carousel->optionsObj->lightboxClickOverlayToClose) && $this->carousel->optionsObj->lightboxClickOverlayToClose!=$this->lightboxClickOverlayToClose)
            $lightboxOptionsObj->clickOverlayToClose = (boolean)$this->carousel->optionsObj->lightboxClickOverlayToClose;
        //touchwipe
        //if(isset($this->carousel->optionsObj->lightboxTouchWipe) && $this->carousel->optionsObj->lightboxTouchWipe)
        //    $lightboxOptionsObj->clickOverlayToClose = (boolean)$this->carousel->optionsObj->lightboxClickOverlayToClose;


        $carouselOptionsObj->beforeInit = "eventBI"; 
        $carouselOptionsObj->afterInit = "eventAI"; 
        $carouselOptionsObj->afterMove = "eventAM"; 
        $carouselOptionsObj->startDragging = "eventSD"; 
    
        $eventBI = 'beforeInit:function(el){eventBI}';
        $eventAI = 'afterInit:function(el){eventAI}';
        $eventAM = 'afterMove:function(el){eventAM}';
        $eventSD = 'startDragging:function(el){eventSD}';

        $eventBIMethods = '';
        $eventAIMethods = '';
        $eventAMMethods = '';
        $eventSDMethods = '';

        //random: beforeInit:function(el){owlRandom(el)}
        if(isset($this->carousel->optionsObj->random) && $this->carousel->optionsObj->random){
            $eventBIMethods .= 'owlRandom(el);';
        }
        //animation:
        if(!(isset($this->carousel->optionsObj->animationDisable) && $this->carousel->optionsObj->animationDisable)){
            $eventAIMethods .= 'addAnim(el);';
            $eventAMMethods .= 'addAnim(el);';
        } 
        //progress bar
        if(isset($this->carousel->optionsObj->progressBar) && $this->carousel->optionsObj->progressBar){
        if(isset($this->carousel->optionsObj->singleItem) && $this->carousel->optionsObj->singleItem){
        if(isset($this->carousel->optionsObj->autoPlay) && $this->carousel->optionsObj->autoPlay>0){
            $eventAIMethods .= 'progressBar(el, '.$this->carousel->optionsObj->autoPlay.');';
            $eventAMMethods .= 'moved('.$this->carousel->optionsObj->autoPlay.');';
            $eventSDMethods .= 'pauseOnDragging();';
            //pauseOnHover:
            if(isset($this->carousel->optionsObj->stopOnHover) && $this->carousel->optionsObj->stopOnHover>0){
                $eventBIMethods .= 'stopCarouselOnHover(el);';    
            }    
        }
        }
        }

        $eventBI = str_replace('eventBI', $eventBIMethods, $eventBI); //echo $eventBI;die;
        $eventAI = str_replace('eventAI', $eventAIMethods, $eventAI);
        $eventAM = str_replace('eventAM', $eventAMMethods, $eventAM);
        $eventSD = str_replace('eventSD', $eventSDMethods, $eventSD);

        //prepare js:
        //owl
        $js = sprintf('$("#%s").owlCarousel(%s);', $this->carousel->containerID, $jh->encode($carouselOptionsObj));
        //nivo lightbox
        if($this->carousel->optionsObj->lightbox){
            $js .= sprintf('if ( $.isFunction($.fn.nivoLightbox) ) {');
            $js .= sprintf('$("#%s a").nivoLightbox(%s);', $this->carousel->containerID, $jh->encode($lightboxOptionsObj));

            //touch wipe
            if($this->carousel->optionsObj->lightboxTouchWipe){
                $js .= sprintf('$("body").touchwipe({wipeLeft: function(){$(".nivo-lightbox-next").click(); }, wipeRight: function(){$(".nivo-lightbox-prev").click(); }, min_move_x: 20, min_move_y: 20, preventDefaultEvents: false});');
            }
            $js .= sprintf('}');
        }
        $this->carousel->js = $js;

        //event method replace did it because can't remove out "" around event with using c5 json helper
        $this->carousel->js = str_replace('"beforeInit":"eventBI"', $eventBI, $this->carousel->js);
        $this->carousel->js = str_replace('"afterInit":"eventAI"', $eventAI, $this->carousel->js);
        $this->carousel->js = str_replace('"afterMove":"eventAM"', $eventAM, $this->carousel->js);
        $this->carousel->js = str_replace('"startDragging":"eventSD"', $eventSD, $this->carousel->js);
        //echo $this->carousel->js;die;
    }

    //prepare css:
    private function prepareCSS()
    {
        $css = '';

        //progress bar
        if(isset($this->carousel->optionsObj->progressBar) && $this->carousel->optionsObj->progressBar ){
            if(isset($this->carousel->optionsObj->progressBarHeight) && $this->carousel->optionsObj->progressBarHeight ){
                $css.= sprintf('#%s  #bar{height: %dpx;}' ,$this->carousel->containerID, (int)$this->carousel->optionsObj->progressBarHeight);
            }    
            if(isset($this->carousel->optionsObj->progressBarBGColor) && $this->carousel->optionsObj->progressBarBGColor ){
                $css.= sprintf('#%s  #progressBar{background: %s;}' ,$this->carousel->containerID, $this->carousel->optionsObj->progressBarBGColor);
            }    
            if(isset($this->carousel->optionsObj->progressBarFillColor) && $this->carousel->optionsObj->progressBarFillColor ){
                $css.= sprintf('#%s  #bar{background: %s;}' ,$this->carousel->containerID, $this->carousel->optionsObj->progressBarFillColor);
            }    
        }

        //navigation
        if(isset($this->carousel->optionsObj->navigationPosition) ){
            $css.= sprintf('#%s .owl-controls .owl-buttons div.owl-prev{left: %dpx;}' ,$this->carousel->containerID, (int)$this->carousel->optionsObj->navigationPosition);
            $css.= sprintf('#%s .owl-controls .owl-buttons div.owl-next{right: %dpx;}' ,$this->carousel->containerID, (int)$this->carousel->optionsObj->navigationPosition);
        }
        if(isset($this->carousel->optionsObj->navigationSize) && $this->carousel->optionsObj->navigationSize>0 ){
            $css.= sprintf('#%s .owl-controls .owl-buttons div{width: %dpx;height: %dpx;margin-top: -%dpx;}' ,$this->carousel->containerID, (int)$this->carousel->optionsObj->navigationSize, (int)$this->carousel->optionsObj->navigationSize, (int)($this->carousel->optionsObj->navigationSize/2));
        }
        if(isset($this->carousel->optionsObj->navigationThickness) && $this->carousel->optionsObj->navigationThickness>0){
            $css.= sprintf('#%s .owl-controls .owl-buttons div{border-width: %dpx;}' ,$this->carousel->containerID, $this->carousel->optionsObj->navigationThickness);
        }
        if(isset($this->carousel->optionsObj->navigationOpacity) && $this->carousel->optionsObj->navigationOpacity>0 ){
            $css.= sprintf('#%s:hover .owl-controls .owl-buttons div{opacity: %f;}' ,$this->carousel->containerID, $this->carousel->optionsObj->navigationOpacity);
        }
        if(isset($this->carousel->optionsObj->navigationColor) ){
            $css.= sprintf('#%s .owl-controls .owl-buttons div{border-color: %s;}' ,$this->carousel->containerID, $this->carousel->optionsObj->navigationColor);
        }

        //pagination position
        if(isset($this->carousel->optionsObj->paginationPosition) ){
            $css.= sprintf('#%s .owl-controls{margin-top: %dpx;}' ,$this->carousel->containerID, $this->carousel->optionsObj->paginationPosition);
        }
        //pagination size
        if(isset($this->carousel->optionsObj->paginationSize) ){
            $css.= sprintf('#%s .owl-controls .owl-page span{width: %dpx;height: %dpx;border-radius: %dpx;}', $this->carousel->containerID, (int)$this->carousel->optionsObj->paginationSize, (int)$this->carousel->optionsObj->paginationSize, (int)$this->carousel->optionsObj->paginationSize);
        }
        if(isset($this->carousel->optionsObj->paginationColor) && strlen($this->carousel->optionsObj->paginationColor)>1 ){
            $css.= sprintf('#%s .owl-controls .owl-page span{background-color: %s;}', $this->carousel->containerID, $this->carousel->optionsObj->paginationColor);
        }

        //carousel bg color
        if(isset($this->carousel->optionsObj->carouselBgColor) && strlen($this->carousel->optionsObj->carouselBgColor)>0){
            $css.= sprintf('#%s {background-color: %s;}' ,$this->carousel->containerID ,$this->carousel->optionsObj->carouselBgColor);
        }
        //items bg color (general for all items)
        if(isset($this->carousel->optionsObj->itemsBgColor) && strlen($this->carousel->optionsObj->itemsBgColor)>0){
            $css.= sprintf('#%s .item{background-color: %s;}' ,$this->carousel->containerID, $this->carousel->optionsObj->itemsBgColor);
        }
        //(items) font color (general for all items)
        if(isset($this->carousel->optionsObj->fontColor) && strlen($this->carousel->optionsObj->fontColor)>0){
            $css.= sprintf('#%s .item *{color: %s;}' ,$this->carousel->containerID ,$this->carousel->optionsObj->fontColor );
        }
        //items padding (general for all items)
        if(isset($this->carousel->optionsObj->itemsPaddingTop) && strlen($this->carousel->optionsObj->itemsPaddingTop)>0){
            $css.= sprintf('#%s .item {padding-top: %spx;}' ,$this->carousel->containerID ,$this->carousel->optionsObj->itemsPaddingTop );
        }
        if(isset($this->carousel->optionsObj->itemsPaddingRight) && strlen($this->carousel->optionsObj->itemsPaddingRight)>0){
            $css.= sprintf('#%s .item {padding-right: %spx;}' ,$this->carousel->containerID ,$this->carousel->optionsObj->itemsPaddingRight );
        }
        if(isset($this->carousel->optionsObj->itemsPaddingBottom) && strlen($this->carousel->optionsObj->itemsPaddingBottom)>0){
            $css.= sprintf('#%s .item {padding-bottom: %spx;}' ,$this->carousel->containerID ,$this->carousel->optionsObj->itemsPaddingBottom );
        }
        if(isset($this->carousel->optionsObj->itemsPaddingLeft) && strlen($this->carousel->optionsObj->itemsPaddingLeft)>0){
            $css.= sprintf('#%s .item {padding-left: %spx;}' ,$this->carousel->containerID ,$this->carousel->optionsObj->itemsPaddingLeft );
        }
        if(isset($this->carousel->optionsObj->carouselCss) && strlen($this->carousel->optionsObj->carouselCss)>0){
            $css.= sprintf('#%s {%s}' ,$this->carousel->containerID ,$this->carousel->optionsObj->carouselCss );
        }
        if(isset($this->carousel->optionsObj->itemsCss) && strlen($this->carousel->optionsObj->itemsCss)>0){
            $css.= sprintf('#%s .item {%s}' ,$this->carousel->containerID ,$this->carousel->optionsObj->itemsCss );
        }
        if(isset($this->carousel->optionsObj->itemsChildrenCss) && strlen($this->carousel->optionsObj->itemsChildrenCss)>0){
            $css.= sprintf('#%s .item *{%s}' ,$this->carousel->containerID ,$this->carousel->optionsObj->itemsChildrenCss );
        }
        if(isset($this->carousel->optionsObj->itemsImagesCss) && strlen($this->carousel->optionsObj->itemsImagesCss)>0){
            $css.= sprintf('#%s .item img{%s}' ,$this->carousel->containerID ,$this->carousel->optionsObj->itemsImagesCss );
        }
        if(isset($this->carousel->optionsObj->itemsTitlesCss) && strlen($this->carousel->optionsObj->itemsTitlesCss)>0){
            $css.= sprintf('#%s .item .item-header{%s}' ,$this->carousel->containerID ,$this->carousel->optionsObj->itemsTitlesCss );
        }
        if(isset($this->carousel->optionsObj->itemsDescriptionsCss) && strlen($this->carousel->optionsObj->itemsDescriptionsCss)>0){
            $css.= sprintf('#%s .item .item-description{%s}' ,$this->carousel->containerID ,$this->carousel->optionsObj->itemsDescriptionsCss );
        }
        if(isset($this->carousel->optionsObj->itemsExtraTextsCss) && strlen($this->carousel->optionsObj->itemsExtraTextsCss)>0){
            $css.= sprintf('#%s .item .item-extra-text{%s}' ,$this->carousel->containerID ,$this->carousel->optionsObj->itemsExtraTextsCss );
        }
        if(isset($this->carousel->optionsObj->styles) && strlen($this->carousel->optionsObj->styles)>0){
            $css.= sprintf('%s' ,$this->carousel->optionsObj->styles );
        }

        //btn
        if(isset($this->carousel->optionsObj->buttonDefaultBGColor) && strlen($this->carousel->optionsObj->buttonDefaultBGColor)>0){
            list($r,$g,$b) = array_map('hexdec',str_split(trim($this->carousel->optionsObj->buttonDefaultBGColor, '#'),2));
            if(strlen($this->carousel->optionsObj->buttonDefaultBGOpacity)<1) $this->carousel->optionsObj->buttonDefaultBGOpacity=1; //backward compatiblity
            $css.= sprintf('#%s .item .item-btn{background-color: rgba(%d, %d, %d, %f);}' ,$this->carousel->containerID, $r, $g, $b, $this->carousel->optionsObj->buttonDefaultBGOpacity );
        }
        if(isset($this->carousel->optionsObj->buttonDefaultFontColor) && strlen($this->carousel->optionsObj->buttonDefaultFontColor)>0){
            $css.= sprintf('#%s .item .item-btn{color: %s!important;}' ,$this->carousel->containerID, $this->carousel->optionsObj->buttonDefaultFontColor );
        }
        if(isset($this->carousel->optionsObj->buttonDefaultBorderWidth) && strlen($this->carousel->optionsObj->buttonDefaultBorderWidth)>0){
            $css.= sprintf('#%s .item .item-btn{border-width: %dpx;}' ,$this->carousel->containerID, $this->carousel->optionsObj->buttonDefaultBorderWidth );
        }
        if(isset($this->carousel->optionsObj->buttonDefaultBorderColor) && strlen($this->carousel->optionsObj->buttonDefaultBorderColor)>0){
            $css.= sprintf('#%s .item .item-btn{border-color: %s;}' ,$this->carousel->containerID, $this->carousel->optionsObj->buttonDefaultBorderColor );
        }
        if(isset($this->carousel->optionsObj->buttonDefaultBorderRadius) && strlen($this->carousel->optionsObj->buttonDefaultBorderRadius)>0){
            $css.= sprintf('#%s .item .item-btn{border-radius: %dpx;}' ,$this->carousel->containerID, $this->carousel->optionsObj->buttonDefaultBorderRadius );
        }
        if(isset($this->carousel->optionsObj->buttonDefaultPaddingVer) && strlen($this->carousel->optionsObj->buttonDefaultPaddingVer)>0){
            $css.= sprintf('#%s .item .item-btn{padding-top: %dpx;padding-bottom: %dpx;}' ,$this->carousel->containerID, $this->carousel->optionsObj->buttonDefaultPaddingVer, $this->carousel->optionsObj->buttonDefaultPaddingVer );
        }
        if(isset($this->carousel->optionsObj->buttonDefaultPaddingHor) && strlen($this->carousel->optionsObj->buttonDefaultPaddingHor)>0){
            $css.= sprintf('#%s .item .item-btn{padding-left: %dpx;padding-right: %dpx;}' ,$this->carousel->containerID, $this->carousel->optionsObj->buttonDefaultPaddingHor, $this->carousel->optionsObj->buttonDefaultPaddingHor );
        }

        if(isset($this->carousel->optionsObj->buttonHoverBGColor) && strlen($this->carousel->optionsObj->buttonHoverBGColor)>0){
            list($r,$g,$b) = array_map('hexdec',str_split(trim($this->carousel->optionsObj->buttonHoverBGColor, '#'),2));
            if(strlen($this->carousel->optionsObj->buttonHoverBGOpacity)<1) $this->carousel->optionsObj->buttonHoverBGOpacity=1; //backward compatiblity
            $css.= sprintf('#%s .item .item-btn:hover{background-color: rgba(%d, %d, %d, %f);}' ,$this->carousel->containerID, $r, $g, $b, $this->carousel->optionsObj->buttonHoverBGOpacity );
        }
        if(isset($this->carousel->optionsObj->buttonHoverFontColor) && strlen($this->carousel->optionsObj->buttonHoverFontColor)>0){
            $css.= sprintf('#%s .item .item-btn:hover{color: %s!important;}' ,$this->carousel->containerID, $this->carousel->optionsObj->buttonHoverFontColor );
        }
        if(isset($this->carousel->optionsObj->buttonHoverBorderWidth) && strlen($this->carousel->optionsObj->buttonHoverBorderWidth)>0){
            $css.= sprintf('#%s .item .item-btn:hover{border-width: %dpx;}' ,$this->carousel->containerID, $this->carousel->optionsObj->buttonHoverBorderWidth );
        }
        if(isset($this->carousel->optionsObj->buttonHoverBorderColor) && strlen($this->carousel->optionsObj->buttonHoverBorderColor)>0){
            $css.= sprintf('#%s .item .item-btn:hover{border-color: %s;}' ,$this->carousel->containerID, $this->carousel->optionsObj->buttonHoverBorderColor );
        }
        if(isset($this->carousel->optionsObj->buttonHoverBorderRadius) && strlen($this->carousel->optionsObj->buttonHoverBorderRadius)>0){
            $css.= sprintf('#%s .item .item-btn:hover{border-radius: %dpx;}' ,$this->carousel->containerID, $this->carousel->optionsObj->buttonHoverBorderRadius );
        }
        if(isset($this->carousel->optionsObj->buttonHoverPaddingVer) && strlen($this->carousel->optionsObj->buttonHoverPaddingVer)>0){
            $css.= sprintf('#%s .item .item-btn:hover{padding-top: %dpx;padding-bottom: %dpx;}' ,$this->carousel->containerID, $this->carousel->optionsObj->buttonHoverPaddingVer, $this->carousel->optionsObj->buttonHoverPaddingVer );
        }
        if(isset($this->carousel->optionsObj->buttonHoverPaddingHor) && strlen($this->carousel->optionsObj->buttonHoverPaddingHor)>0){
            $css.= sprintf('#%s .item .item-btn:hover{padding-left: %dpx;padding-right: %dpx;}' ,$this->carousel->containerID, $this->carousel->optionsObj->buttonHoverPaddingHor, $this->carousel->optionsObj->buttonHoverPaddingHor );
        }

        if(isset($this->carousel->optionsObj->buttonCss) && strlen($this->carousel->optionsObj->buttonCss)>0){
            $css.= sprintf('#%s .item .item-btn{%s}' ,$this->carousel->containerID ,$this->carousel->optionsObj->buttonCss );
        }

        //animation
        if(isset($this->carousel->optionsObj->animationDuration) && $this->carousel->optionsObj->animationDuration>0){
            $css.= sprintf('#%s .owl-item.active .woc-caption-holder{animation-duration: %dms!important;-webkit-animation-duration: %dms!important;}' 
                            ,$this->carousel->containerID ,$this->carousel->optionsObj->animationDuration ,$this->carousel->optionsObj->animationDuration
                          );
        }
        if(isset($this->carousel->optionsObj->animationDelay) && $this->carousel->optionsObj->animationDelay>0){
            $css.= sprintf('#%s .owl-item.active .woc-caption-holder{animation-delay: %dms!important;-webkit-animation-delay: %dms!important;}' 
                            ,$this->carousel->containerID ,$this->carousel->optionsObj->animationDelay ,$this->carousel->optionsObj->animationDelay
                          );
        }

        //generate css for every item image
        foreach((object)$this->carousel->itemsObj as $key=>$value){
            //bg color
            if(isset($value->itemBgColor) && strlen($value->itemBgColor)>0){
                $css.= sprintf('#%s #item-%d {background-color: #%s;}'
                               ,$this->carousel->containerID
                               ,$value->itemID
                               ,$value->itemBgColor
                               );
            }
            //caption padding
            if(isset($value->captionPadding)){
                $css.= sprintf('#%s #item-%d .woc-caption-wrapper{padding: %d%%;}'
                               ,$this->carousel->containerID
                               ,$value->itemID
                               ,$value->captionPadding
                               );
            }
        }

        if(isset($this->carousel->optionsObj->singleItem) && $this->carousel->optionsObj->singleItem){ //available for single item

            $this->carousel->containerClass = '';
            //items styles for fullscreen slider:
            if(isset($this->carousel->optionsObj->fullscreen) && $this->carousel->optionsObj->fullscreen){
                //fullscreen container class:
                $this->carousel->containerClass .= ' whale-owl-full-screen-slider';

                $itemStyle = 'background:url(%s) %d%% top no-repeat; background-size:cover; position: relative;';
                foreach((object)$this->carousel->itemsObj as $key=>$value){//generate style for every item container (bg image)
                if(isset($value->itemImageSrc) && strlen($value->itemImageSrc)>0){
                    $this->carousel->itemsObj->{$key}->itemStyle = sprintf($itemStyle, $value->itemImageSrc, (int)$this->carousel->optionsObj->bgPosition);
                }}
            }
            //items styles for responsive caption:
            if(isset($this->carousel->optionsObj->responsiveCaption) && $this->carousel->optionsObj->responsiveCaption){
                //responsiveCaption container class:
                $this->carousel->containerClass .= ' whale-owl-responsive-caption';
            }
        }

        //fontEmbed
        if(isset($this->carousel->optionsObj->embedFont) && strlen($this->carousel->optionsObj->embedFont)>0){
            $cssEmbed= sprintf($this->carousel->optionsObj->embedFont );
        }

        $this->carousel->css = $css;
        $this->carousel->cssEmbed = $cssEmbed;
    }

    public function validate($args)
    {
        $e = Core::make('helper/validation/error');
        if((int)$this->post('carouselID')==0) {
            $e->add(t('You must select a carousel.') );
        }
        return $e;
    }

}