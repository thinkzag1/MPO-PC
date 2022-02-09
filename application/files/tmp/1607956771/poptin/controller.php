<?php

namespace Concrete\Package\Poptin;

use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Package\Package;
use Concrete\Core\Page\Page;
use Concrete\Core\Page\Single;
use Concrete\Core\Support\Facade\Package as PackageFacade;

final class Controller extends Package
{
    protected $pkgHandle = 'poptin';
    protected $appVersionRequired = '8.0';
    protected $pkgVersion = '0.9.9';

    /** @var Repository */
    protected $config;

    public function getPackageName()
    {
        return t('Poptin');
    }

    public function getPackageDescription()
    {
        return t('Free exit intent popups. Get more emails, leads, and sales.');
    }

    public function on_start()
    {
        
    }

    public function install()
    {
        $this->config = $this->app->make(Repository::class);
        $pkg = parent::install();
        $this->installEverything($pkg);

        $this->config->save('poptin.enabled', true);
    }

    public function upgrade()
    {
        $this->config = $this->app->make(Repository::class);
        $pkg = PackageFacade::getByHandle($this->pkgHandle);
        $this->installEverything($pkg);
    }

    public function installEverything($pkg)
    {
        $this->installDashboardPage($pkg);
    }

    private function installDashboardPage($pkg)
    {
        $path = '/dashboard/system/poptin';

        /** @var Page $page */
        $page = Page::getByPath($path);
        if ($page && !$page->isError()) {
            return;
        }

        $singlePage = Single::add($path, $pkg);
        $singlePage->update($this->getPackageName());
    }

    public function uninstall() {
        parent::uninstall();
        $config = $this->app->make('site')->getSite()->getConfigRepository();

        $config = $this->app->make(Repository::class);
        $poptinid = $config->get('poptin.id') ?: '';
        if ($poptinid && (strlen($poptinid) == 13)) {
            $script = '<script id="pixel-script-poptin" src="https://cdn.popt.in/pixel.js?id=' . $poptinid . '" async="true"></script>';
                
            $existing_code = $config->get('seo.tracking.code.header');
            $existing_code = str_replace($script, "", $existing_code);
            $new_code = $existing_code;
            $config->save('seo.tracking.code.header', $new_code);

            // Remove config variables
            $config->save('poptin.id', '');
            $config->save('poptin.user_id', '');
            $config->save('poptin.marketplace_token', '');
            $config->save('poptin.marketplace_email_id', '');

        }
   }
}
