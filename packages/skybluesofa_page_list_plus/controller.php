<?php 
/*
* Page List Plus for c5
*
* @package Block Quoter
* @author Dave Rogers <connect@skybluesofa.com>
* @version 5.7.0.0.0.1
* @copyright Copyright (c) 2014, Dave Rogers
* @license http://www.concrete5.org/help/legal/commercial_add-on_license/ c5 Commercial Add-On License
*/
namespace Concrete\Package\SkybluesofaPageListPlus;

use \Symfony\Component\ClassLoader\MapClassLoader as SymfonyMapClassloader;
use \Concrete\Package\SkybluesofaPageListPlus\Src\Installer;
use Package;
use Route;
use Router;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends Package
{

    protected $pkgDescription = "Page Lists with keyword and page attribute filtering as well as built-in list titles";
    protected $pkgName = "Page List+";
    protected $pkgHandle = 'skybluesofa_page_list_plus';
    protected $appVersionRequired = '5.8.0';
    protected $pkgVersion = '2.0.0';

    public static $pageListPlusFilters = array(
        'boolean' => 'Boolean',
        'date_time' => 'DateTime',
        'image_file' => 'ImageFile',
        'number' => 'Number',
        'rating' => 'Rating',
        'select' => 'Select',
        'standard' => 'Standard',
        'text' => 'Text',
        'textarea' => 'Textarea',
        'topics' => 'Topics',
        'multi_date' => 'MultiDate',
        'page_selector' => 'PageSelector'
//        'event_category' => 'EventCategory',
  //      'price' => 'Price',
    );

    public function on_start()
    {
        $this->registerRoutes();
    }

    public function install()
    {
        $preInstallationErrors = Installer::preInstallationCheck();
        if (!$preInstallationErrors) {
            $pkg = parent::install();
            Installer::install($pkg);
        } else {
            return $preInstallationErrors;
        }
    }

    public function upgrade()
    {
        $preInstallationErrors = Installer::preInstallationCheck();
        if (!$preInstallationErrors) {
            $pkg = $this->getByID($this->getPackageID());
            parent::upgrade();
            Installer::upgrade($pkg);
        } else {
            return $preInstallationErrors;
        }
    }

    public function uninstall()
    {
        $pkg = $this->getByID($this->getPackageID());
        Installer::uninstall($pkg);
        parent::uninstall();
    }

    private function registerRoutes()
    {
        Route::register(
            Router::route(array('/preview', 'skybluesofa_page_list_plus')),
            '\Concrete\Package\SkybluesofaPageListPlus\Src\Preview::render'
        );
        Route::register(
            Router::route(array('/reload', 'skybluesofa_page_list_plus')),
            '\Concrete\Package\SkybluesofaPageListPlus\Src\Reload::render'
        );
        Route::register(
            '/rss/{identifier}',
            '\Concrete\Package\SkybluesofaPageListPlus\Src\Feed::get',
            'rss',
            array('identifier' => '[A-Za-z0-9_/.]+')
        );
    }
}
