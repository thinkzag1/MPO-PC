<?php 
 /**
 * @author      shahroq <shahroq \at\ yahoo.com>
 * @copyright   Copyright (c) 2016 shahroq
 * http://concrete5.killerwhalesoft.com/addons/
 */

namespace Concrete\Package\WhaleOwlCarousel;
use Core;
use Package;
use SinglePage;
use Loader;
use Block;
use BlockType;
use \Concrete\Core\Attribute\Type as AttributeType;
use \Concrete\Core\Attribute\Key\FileKey as FileAttributeKey;
use Route;
use \Concrete\Core\Http\Request;
use FileSet;
use FileImporter;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package {

	protected $pkgHandle = 'whale_owl_carousel';
    protected $appVersionRequired = '5.7.3';
    protected $pkgVersion = '2.5.5';

    public function getPackageDescription()
    {
        return t("Whale <a target='_blank' href='http://owlgraphic.com/owlcarousel/'>OWL Carousel</a>");
    }

    public function getPackageName()
    {
        return t("Whale OWL Carousel");
    }

    public function install()
    {
    	$pkg = parent::install();
	    // install block
        BlockType::installBlockTypeFromPackage('whale_owl_carousel', $pkg);

		$this->install_single_page($pkg);
        $this->create_sample_1($pkg);
        $this->create_sample_2($pkg);
        $this->create_sample_3($pkg);
        $this->create_sample_4($pkg);
    }

    public function on_start()
    {
    }

 	private function install_single_page($pkg)
    {
		$p = SinglePage::add('/dashboard/files/whale_owl_carousel',$pkg);
		if (is_object($p)) {
            $p->update(array('cName'=>t('Whale Owl Carousel'), 'cDescription'=>t('Whale Owl Carousel')));
		}
	}

	public function uninstall()
    {
		parent::uninstall();

		//drop tables
		$db = Loader::db();
        $db->Execute('DROP TABLE IF EXISTS `whaleOwlCarousel`');
        $db->Execute('DROP TABLE IF EXISTS `btWhaleOwlCarousel`');

	}

    private function create_sample_1($pkg)
    {

        //first import sample images
        $pkgDir = $pkg->getPackagePath() . "/images/demo/";

        $fs = FileSet::createAndGetSet('OWL Carousel Demo Images', FileSet::TYPE_PUBLIC);

        $f = new FileImporter();

        //add slide files
        $newFile = $f->import($pkgDir.'01-touch.png');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'02-grab.png');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'03-responsive.png');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'04-css3.png');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'05-multi.png');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'06-modern.png');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'07-zombie.png');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'08-controls.png');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'09-feather.png');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'10-tons.png');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $itemHeaders = array("Touch", "Grab", "Responsive", "CSS3", "Multiply", "Modern", "Zombie", "Take Control", "Light", "Tons");
        $itemDescriptions = array("Can touch this", "Can grab this", "Fully responsive", "3D Acceleration", "Owls on page", "Browser Compatibility", "Browser Compatibility", "The way you like", "As a feather", "of options");
        $itemBgColors = array("42BDC2", "7FC242", "FF8A3C", "FFD800", "388BD1", "A1DEF8", "3FBF79", "DB6AC5", "FEE664", "CAD3D0");

        $options = array(
                        "showTitle"=>true,
                        "showDescription"=>true,
                        "singleItem"=>0,
                        "itemsNum"=>5,
                        "itemsDesktopX"=>1199,
                        "itemsDesktopY"=>4,
                        "itemsDesktopSmallX"=>979,
                        "itemsDesktopSmallY"=>3,
                        "itemsTabletX"=>768,
                        "itemsTabletY"=>2,
                        "itemsTabletSmallX"=>0,
                        "itemsTabletSmallY"=>0,
                        "itemsMobileX"=>479,
                        "itemsMobileY"=>2,
                        //"itemsCustomX"=>0,
                        //"itemsCustomY"=>0,
                        "itemsScaleUp"=>0,
                        "slideSpeed"=>200,
                        "paginationSpeed"=>"800",
                        "rewindSpeed"=>1000,
                        "autoPlay"=>0,
                        "stopOnHover"=>0,
                        "navigation"=>0,
                        "navigationTextNext"=>"Next",
                        "navigationTextPrev"=>"Prev",
                        "navigationPosition"=>25,
                        "navigationSize"=>20,
                        "navigationThickness"=>2,
                        "navigationOpacity"=>1,
                        "navigationColor"=>'#666666',
                        "rewindNav"=>1,
                        "scrollPerPage"=>0,
                        "pagination"=>1,
                        "paginationPosition"=>10,
                        "paginationSize"=>15,
                        "paginationNumbers"=>0,
                        "responsive"=>1,
                        "responsiveRefreshRate"=>200,
                        //"responsiveBaseWidth"=>'window',
                        //"baseClass"=>'owl-carousel',
                        "lazyLoad"=>0,
                        "lazyFollow"=>1,
                        "lazyEffect"=>'fade',
                        "autoHeight"=>0,
                        "dragBeforeAnimFinish"=>1,
                        "mouseDrag"=>1,
                        "touchDrag"=>1,
                        "addClassActive"=>0,
                        "transitionStyle"=>0,

                        "carouselBgColor"=>"",
                        "itemsBgColor"=>"",
                        "fontColor"=>"#ffffff",
                        "itemsPaddingTop"=>30,
                        "itemsPaddingRight"=>0,
                        "itemsPaddingBottom"=>30,
                        "itemsPaddingLeft"=>0,
                        "carouselCss"=>'',
                        "itemsCss"=>'margin: 0 10px;',
                        "itemsChildrenCss"=>'font-family: sans-serif;',
                        "animationDisable"=>1,
                        "animationDuration"=>1000,
                        "animationDelay"=>0,
                         );



        foreach ($slideImageID as $key=>$value) {
            $items[] = array(
                           "itemID"=>$key,
                           "itemImageID"=>$value,
                           "itemHeader"=>$itemHeaders[$key],
                           "itemHeaderType"=>"h3",
                           "itemDescription"=>$itemDescriptions[$key],
                           "itemActive"=>"1",
                           "itemUrlType"=>"internal",
                           "itemUrlNewWindow"=>"0",
                           "itemUrlExternal"=>"",
                           "itemUrlInternal"=>"",
                           "itemImageWidth"=>"",
                           "itemImageHeight"=>"",
                           "itemBgColor"=>$itemBgColors[$key],
                      );
        }

        $db = Loader::db();
        $jh = Loader::helper('json');

        $data = array(
                      'OwlCarouselDemo',
                      'owl',
                      'owl',
                      $jh->encode((object)$options),
                      $jh->encode((object)$items)
                     );
        $db->query("INSERT INTO `whaleOwlCarousel` (`carouselName`, `carouselPlugin`, `carouselTheme`, `options`, `items`) VALUES (?,?,?,?,?); " , $data
                   );

    }

    private function create_sample_2($pkg)
    {

        //first import sample images
        $pkgDir = $pkg->getPackagePath() . "/images/demo/";

        $fs = FileSet::createAndGetSet('OWL Carousel Demo Images', FileSet::TYPE_PUBLIC);

        $f = new FileImporter();

        //add slide files
        $newFile = $f->import($pkgDir.'client-1.jpg');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'client-2.jpg');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'client-3.jpg');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'client-4.jpg');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $itemHeaders = array("Tori", "Louie", "Polly Jean", "Michael");
        $itemDescriptions = array("Mauris sit amet diam quis est rutrum pulvinar eget quis eros. In justo ipsum, scelerisque non efficitur malesuada, ornare nec augue.",
                                  "In quis ante magna. In hac habitasse platea dictumst. Duis et leo ac ante consectetur dignissim. Sed eget purus posuere, egestas neque nec.",
                                  "Ut at sapien vel sem commodo faucibus. Morbi ut lorem ligula. Vivamus sodales nunc ut aliquam aliquam. Fusce dapibus commodo ante.",
                                  "Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur scelerisque neque sem, nec lacinia sem tempor eu.");
        $itemExtraTexts = array("Singer", "Comedian", "Singer", "Actor");

        $options = array(
                        "showTitle"=>true,
                        "showDescription"=>true,
                        "showExtraText"=>true,
                        "singleItem"=>0,
                        "itemsNum"=>3,
                        "itemsDesktopX"=>1199,
                        "itemsDesktopY"=>3,
                        "itemsDesktopSmallX"=>979,
                        "itemsDesktopSmallY"=>3,
                        "itemsTabletX"=>768,
                        "itemsTabletY"=>2,
                        "itemsTabletSmallX"=>0,
                        "itemsTabletSmallY"=>0,
                        "itemsMobileX"=>479,
                        "itemsMobileY"=>2,
                        //"itemsCustomX"=>0,
                        //"itemsCustomY"=>0,
                        "itemsScaleUp"=>0,
                        "slideSpeed"=>200,
                        "paginationSpeed"=>"800",
                        "rewindSpeed"=>1000,
                        "autoPlay"=>3000,
                        "stopOnHover"=>1,
                        "navigation"=>0,
                        "navigationTextNext"=>"Next",
                        "navigationTextPrev"=>"Prev",
                        "navigationPosition"=>25,
                        "navigationSize"=>20,
                        "navigationThickness"=>2,
                        "navigationOpacity"=>1,
                        "navigationColor"=>'#666666',
                        "rewindNav"=>1,
                        "scrollPerPage"=>0,
                        "pagination"=>1,
                        "paginationPosition"=>10,
                        "paginationNumbers"=>0,
                        "responsive"=>1,
                        "responsiveRefreshRate"=>200,
                        //"responsiveBaseWidth"=>'window',
                        //"baseClass"=>'owl-carousel',
                        "lazyLoad"=>0,
                        "lazyFollow"=>1,
                        "lazyEffect"=>'fade',
                        "autoHeight"=>0,
                        "dragBeforeAnimFinish"=>1,
                        "mouseDrag"=>1,
                        "touchDrag"=>1,
                        "addClassActive"=>0,
                        "transitionStyle"=>0,

                        "carouselBgColor"=>"",
                        "itemsBgColor"=>"",
                        "fontColor"=>"#555555",
                        "itemsPaddingTop"=>30,
                        "itemsPaddingRight"=>0,
                        "itemsPaddingBottom"=>30,
                        "itemsPaddingLeft"=>0,
                        "carouselCss"=>'',
                        "itemsCss"=>'margin: 0 10px;',
                        "itemsChildrenCss"=>'font-family: sans-serif;',
                        "itemsImagesCss"=>'border-radius: 50%;',
                        "itemsExtraTextsCss"=>'font-style: italic;',
                        "styles"=>".item-description{\r\nposition: relative;\r\npadding: 10px;\r\nbackground: #f5f5f5;\r\n-webkit-border-radius: 10px;\r\n-moz-border-radius: 10px;\r\nborder-radius: 10px;\r\n}\r\n.item-description:after{\r\ncontent: '';\r\nposition: absolute;\r\nborder-style: solid;\r\nborder-width: 0 20px 15px;\r\nborder-color: #f5f5f5 transparent;\r\ndisplay: block;\r\nwidth: 0;\r\nz-index: 1;\r\nmargin-left: -20px;\r\ntop: -15px;\r\nleft: 50%;\r\n}",
                        "animationDisable"=>1,
                        "animationDuration"=>1000,
                        "animationDelay"=>0,
                         );

        foreach ($slideImageID as $key=>$value) {
            $items[] = array(
                           "itemID"=>$key,
                           "itemImageID"=>$value,
                           "itemHeader"=>$itemHeaders[$key],
                           "itemHeaderType"=>"h4",
                           "itemDescription"=>$itemDescriptions[$key],
                           "itemExtraText"=>$itemExtraTexts[$key],
                           "itemActive"=>1,
                           "itemUrlType"=>"internal",
                           "itemUrlNewWindow"=>0,
                           "itemUrlExternal"=>"",
                           "itemUrlInternal"=>"",
                           "itemImageWidth"=>"",
                           "itemImageHeight"=>"",
                           "itemBgColor"=>""
                      );
        }

        $db = Loader::db();
        $jh = Loader::helper('json');

        $data = array(
                      'OwlCarouselDemoTestimonial',
                      'owl',
                      'owl',
                      $jh->encode((object)$options),
                      $jh->encode((object)$items)
                     );
        $db->query("INSERT INTO `whaleOwlCarousel` (`carouselName`, `carouselPlugin`, `carouselTheme`, `options`, `items`) VALUES (?,?,?,?,?); " , $data
                   );

    }

    private function create_sample_3($pkg)
    {

        //first import sample images
        $pkgDir = $pkg->getPackagePath() . "/images/demo/";

        $fs = FileSet::createAndGetSet('OWL Carousel Demo Images', FileSet::TYPE_PUBLIC);

        $f = new FileImporter();

        //add slide files
        $newFile = $f->import($pkgDir.'owl-slide-01.jpg');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'owl-slide-02.jpg');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $itemHeaders = array("Incredible 'Owl'", "Fullscreen Slider");
        $itemDescriptions = array("Carousel / Slider Plugin for all purposes", "New fullscreen features");
        $captionAnimations = array("slideInUp", "slideInDown");

        $options = array(
                        "showTitle"=>true,
                        "showDescription"=>true,
                        "showExtraText"=>false,
                        "itemsNum"=>3,
                        "singleItem"=>1,
                        "fullscreen"=>1,
                        "bgPosition"=>70,
                        "responsiveCaption"=>70,
                        "itemsDesktopX"=>1199,
                        "itemsDesktopY"=>3,
                        "itemsDesktopSmallX"=>979,
                        "itemsDesktopSmallY"=>3,
                        "itemsTabletX"=>768,
                        "itemsTabletY"=>2,
                        "itemsTabletSmallX"=>0,
                        "itemsTabletSmallY"=>0,
                        "itemsMobileX"=>479,
                        "itemsMobileY"=>2,
                        "itemsScaleUp"=>0,
                        "slideSpeed"=>200,
                        "paginationSpeed"=>"800",
                        "rewindSpeed"=>1000,
                        "autoPlay"=>3000,
                        "stopOnHover"=>1,
                        "navigation"=>1,
                        "navigationTextNext"=>"Next",
                        "navigationTextPrev"=>"Prev",
                        "navigationPosition"=>35,
                        "navigationSize"=>30,
                        "navigationThickness"=>4,
                        "navigationOpacity"=>1,
                        "navigationColor"=>'#ffffff',
                        "rewindNav"=>1,
                        "scrollPerPage"=>0,
                        "pagination"=>1,
                        "paginationPosition"=>-30,
                        "paginationSize"=>15,
                        "paginationNumbers"=>0,
                        "responsive"=>1,
                        "responsiveRefreshRate"=>200,
                        //"responsiveBaseWidth"=>'window',
                        //"baseClass"=>'owl-carousel',
                        "lazyLoad"=>0,
                        "lazyFollow"=>1,
                        "lazyEffect"=>'fade',
                        "autoHeight"=>0,
                        "dragBeforeAnimFinish"=>1,
                        "mouseDrag"=>1,
                        "touchDrag"=>1,
                        "addClassActive"=>0,
                        "transitionStyle"=>0,

                        "carouselBgColor"=>"",
                        "itemsBgColor"=>"",
                        "fontColor"=>"#e7e7e7",
                        "itemsPaddingTop"=>0,
                        "itemsPaddingRight"=>0,
                        "itemsPaddingBottom"=>0,
                        "itemsPaddingLeft"=>0,
                        "carouselCss"=>'',
                        "itemsCss"=>'margin: 0;',
                        "itemsChildrenCss"=>'font-family: arial;font-weight:bold;',
                        "itemsTitlesCss"=>'',
                        "itemsDescriptionsCss"=>'',
                        "animationDisable"=>0,
                        "animationDuration"=>1000,
                        "animationDelay"=>0,
                         );

        foreach ($slideImageID as $key=>$value) {
            $items[] = array(
                           "itemID"=>$key,
                           "itemImageID"=>$value,
                           "captionPosition"=>'ml',
                           "captionAlign"=>'left',
                           "captionPadding"=>12,
                           "captionAnimation"=>$captionAnimations[$key],
                           "itemHeader"=>$itemHeaders[$key],
                           "itemHeaderType"=>"h1",
                           "itemDescription"=>$itemDescriptions[$key],
                           "itemActive"=>1,
                           "itemUrlType"=>"internal",
                           "itemUrlNewWindow"=>0,
                           "itemUrlExternal"=>"",
                           "itemUrlInternal"=>"",
                           "itemImageWidth"=>"",
                           "itemImageHeight"=>"",
                           "itemBgColor"=>$itemBgColors[$key],
                      );
        }

        $db = Loader::db();
        $jh = Loader::helper('json');

        $data = array(
                      'OwlCarouselDemo-Fullscreen',
                      'owl',
                      'owl',
                      $jh->encode((object)$options),
                      $jh->encode((object)$items)
                     );
        $db->query("INSERT INTO `whaleOwlCarousel` (`carouselName`, `carouselPlugin`, `carouselTheme`, `options`, `items`) VALUES (?,?,?,?,?); " , $data
                   );

    }

    private function create_sample_4($pkg)
    {

        //first import sample images
        $pkgDir = $pkg->getPackagePath() . "/images/demo/";

        $fs = FileSet::createAndGetSet('OWL Carousel Demo Images', FileSet::TYPE_PUBLIC);

        $f = new FileImporter();

        //add slide files
        $newFile = $f->import($pkgDir.'fullimage1.jpg');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'fullimage2.jpg');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $newFile = $f->import($pkgDir.'fullimage3.jpg');
        $fs->addFileToSet($newFile);
        $slideImageID[] = $newFile->getFileID();

        $itemHeaders = array("Owl Slider Animations", "Contains 76 Effects", "Ultimate Possibilities");
        $itemDescriptions = array("", "", "");
        $captionPositions = array("bl", "tl", "mc");
        $captionAnimations = array("fadeInUp", "fadeInRight", "rotateIn");

        $options = array(
                        "showTitle"=>true,
                        "showDescription"=>true,
                        "showExtraText"=>false,
                        "itemsNum"=>3,
                        "singleItem"=>1,
                        "fullscreen"=>0,
                        "bgPosition"=>70,
                        "responsiveCaption"=>70,
                        "itemsDesktopX"=>1199,
                        "itemsDesktopY"=>3,
                        "itemsDesktopSmallX"=>979,
                        "itemsDesktopSmallY"=>3,
                        "itemsTabletX"=>768,
                        "itemsTabletY"=>2,
                        "itemsTabletSmallX"=>0,
                        "itemsTabletSmallY"=>0,
                        "itemsMobileX"=>479,
                        "itemsMobileY"=>2,
                        "itemsScaleUp"=>0,
                        "slideSpeed"=>200,
                        "paginationSpeed"=>"800",
                        "rewindSpeed"=>1000,
                        "autoPlay"=>5000,
                        "progressBar"=>1,
                        "progressBarHeight"=>2,
                        "progressBarBGColor"=>'#ededed',
                        "progressBarFillColor"=>'#6c6c6c',
                        "stopOnHover"=>1,
                        "navigation"=>1,
                        "navigationTextNext"=>"Next",
                        "navigationTextPrev"=>"Prev",
                        "navigationPosition"=>15,
                        "navigationSize"=>20,
                        "navigationThickness"=>2,
                        "navigationOpacity"=>1,
                        "navigationColor"=>'#ffffff',
                        "rewindNav"=>1,
                        "scrollPerPage"=>0,
                        "pagination"=>1,
                        "paginationPosition"=>-35,
                        "paginationSize"=>15,
                        "paginationColor"=>'#ffffff',
                        "paginationNumbers"=>0,
                        "responsive"=>1,
                        "responsiveRefreshRate"=>200,
                        //"responsiveBaseWidth"=>'window',
                        //"baseClass"=>'owl-carousel',
                        "lazyLoad"=>0,
                        "lazyFollow"=>1,
                        "lazyEffect"=>'fade',
                        "autoHeight"=>0,
                        "dragBeforeAnimFinish"=>1,
                        "mouseDrag"=>1,
                        "touchDrag"=>1,
                        "transitionStyle"=>0,

                        "carouselBgColor"=>"",
                        "itemsBgColor"=>"",
                        "fontColor"=>"#ffffff",
                        "itemsPaddingTop"=>0,
                        "itemsPaddingRight"=>0,
                        "itemsPaddingBottom"=>0,
                        "itemsPaddingLeft"=>0,
                        "carouselCss"=>'',
                        "itemsCss"=>'margin: 0;',
                        "itemsChildrenCss"=>'',
                        "itemsTitlesCss"=>"font-family: 'Roboto'; font-size:40px;font-weight:300;",
                        "itemsDescriptionsCss"=>"font-family: 'Roboto'; font-size:26px;font-weight:300;",
                        "embedFont"=>"<link href='//fonts.googleapis.com/css?family=Roboto:400,100,400italic,700italic,700' rel='stylesheet' type='text/css'>",
                        "buttonDefaultBGColor"=>"#ffffff",
                        "buttonDefaultBGOpacity"=>0,
                        "buttonDefaultFontColor"=>"#ffffff",
                        "buttonDefaultBorderWidth"=>1,
                        "buttonDefaultBorderColor"=>"#ffffff",
                        "buttonDefaultBorderRadius"=>0,
                        "buttonDefaultPaddingVer"=>10,
                        "buttonDefaultPaddingHor"=>35,
                        "buttonHoverBGColor"=>"#ffffff",
                        "buttonHoverBGOpacity"=>1,
                        "buttonHoverFontColor"=>"#000000",
                        "buttonHoverBorderWidth"=>1,
                        "buttonHoverBorderColor"=>"#ffffff",
                        "buttonHoverBorderRadius"=>0,
                        "buttonHoverPaddingVer"=>10,
                        "buttonHoverPaddingHor"=>35,
                        "animationDisable"=>0,
                        "animationDuration"=>1000,
                        "animationDelay"=>0,
                         );

        foreach ($slideImageID as $key=>$value) {
            $items[] = array(
                           "itemID"=>$key,
                           "itemImageID"=>$value,
                           "captionPosition"=>$captionPositions[$key],
                           "captionAlign"=>'left',
                           "captionPadding"=>5,
                           "captionAnimation"=>$captionAnimations[$key],
                           "itemHeader"=>$itemHeaders[$key],
                           "itemHeaderType"=>"h1",
                           "itemDescription"=>$itemDescriptions[$key],
                           "itemActive"=>1,
                           "itemUrlWrapper"=>'button',
                           "itemUrlLabel"=>'Buy',
                           "itemUrlType"=>"external",
                           "itemUrlNewWindow"=>1,
                           "itemUrlExternal"=>"https://www.concrete5.org/marketplace/addons/whale-owl-carousel/",
                           "itemUrlInternal"=>"",
                           "itemImageWidth"=>"",
                           "itemImageHeight"=>"",
                           "itemBgColor"=>$itemBgColors[$key],
                      );
        }

        $db = Loader::db();
        $jh = Loader::helper('json');

        $data = array(
                      'OwlCarouselDemo-Slider',
                      'owl',
                      'owl',
                      $jh->encode((object)$options),
                      $jh->encode((object)$items)
                     );
        $db->query("INSERT INTO `whaleOwlCarousel` (`carouselName`, `carouselPlugin`, `carouselTheme`, `options`, `items`) VALUES (?,?,?,?,?); " , $data
                   );

    }

}