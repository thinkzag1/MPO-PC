<?php
/**
 * @author 		shahroq <shahroq \at\ yahoo.com>
 * @copyright  	Copyright (c) 2017 shahroq
 * http://concrete5.killerwhalesoft.com/addons/
 */
namespace Concrete\Package\WhaleParallaxArea;

use Core;
use Page;
use Block;
use Route;
use Asset;
use Loader;
use Package;
use FileSet;
use Database;
use BlockType;
use AssetList;
use SinglePage;
use FileImporter;
use \Concrete\Core\Http\Request;
use \Concrete\Core\Attribute\Type as AttributeType;
use \Concrete\Core\Attribute\Key\FileKey as FileAttributeKey;

defined('C5_EXECUTE') or die('Access denied.');

class Controller extends Package
{
	protected $pkgHandle = 'whale_parallax_area';
    protected $appVersionRequired = '5.7.3';
    protected $pkgVersion = '2.1.1';


	public function getPackageDescription()
    {
    	return t("Whale Parallax Area");
    }

    public function getPackageName()
    {
    	return t("Parallax Area");
    }

    public function install()
    {
    	$pkg = parent::install();

        $this->install_single_page($pkg);
    }

	public function uninstall()
    {
		parent::uninstall();

        //drop tables
        $db = Loader::db();
        $db->Execute('DROP TABLE IF EXISTS `whaleParallaxArea`');
	}

    private function install_single_page($pkg)
    {
        $p = SinglePage::add('/dashboard/files/whale_parallax_area',$pkg);
          if (is_object($p)) {
            $p->update(array('cName'=>t('Whale Parallax Area'), 'cDescription'=>t('Whale Parallax Area')));
          }
      }


    public function on_start()
    {

        $is_admin = stripos($_SERVER['REQUEST_URI'], 'dashboard');

        $this->db = Database::connection();
        $lastDateModified = $this->db->fetchColumn('SELECT `dateModified` FROM `whaleParallaxArea` ORDER BY `dateModified` DESC LIMIT 1;');
        
        if(!$is_admin && $lastDateModified){ //if there was at least one record

//            $cssFile = DIR_REL . '/application/files/cache/whale_parallax_area/whale-parallax-area.css?v='.md5($lastDateModified); 
//            $jsFile =  DIR_REL . '/application/files/cache/whale_parallax_area/jquery.paroller.min.with.initializer.js?v='.md5($lastDateModified);            
            $cssFile = DIR_REL . '/packages/whale_parallax_area/css/whale-parallax-area.css?v='.md5($lastDateModified); 
            $jsFile =  DIR_REL . '/packages/whale_parallax_area/js/jquery.paroller.min.js?v='.md5($lastDateModified);            

            //$al = AssetList::getInstance(); 
            //$al->register('css', 'wpa', 'css/whale-parallax-area.css', array(), $pkg); 
            //$al->register('css', 'wpa', 'css/whale-parallax-area.css' , array('position' => Asset::ASSET_POSITION_HEADER), $this ); 
            //$this->requireAsset('css', 'wpa');

            $v = \View::getInstance();
            $v->addHeaderItem('<link rel="stylesheet" href="' . $cssFile . '"/>');
            $v->addFooterItem('<script type="text/javascript" src="' . $jsFile . '"></script>');
            //it causes sitemap not working? so i remove it admin pages
        }    
       
    }



}