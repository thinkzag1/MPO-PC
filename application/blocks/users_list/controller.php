<?php
namespace Application\Block\UsersList;

use Concrete\Core\Block\BlockController;

class Controller extends BlockController
{
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = null;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputLifetime = 300;

    /**
     * Used for localization. If we want to localize the name/description we have to include this.
     */
    public function getBlockTypeDescription()
    {
        return t("List of users used for filtering page lists.");
    }

    public function getBlockTypeName()
    {
        return t("Users List");
    }

    public function on_start()
    {
    }
    
    public function view()
    {
        $list = new \Concrete\Core\User\UserList();
        $users = $list->getResults();
        
        $this->set('users', $users);
    }
    
    public function getAuthorLink(\Concrete\Core\User\UserInfo $user = null)
    {
        if ($this->cParentID) {
            $c = \Page::getByID($this->cParentID);
        } else {
            $c = \Page::getCurrentPage();
        }
        if ($user) {
            $nodeName = $user->getUserName();
            $nodeName = strtolower($nodeName); // convert to lowercase
            //$nodeName = Core::make('helper/text')->encodePath($nodeName); // urlencode
            return \URL::page($c).'?authorFilter=' . $user->getUserID();
        } else {
            return \URL::page($c);
        }
    }
    
}