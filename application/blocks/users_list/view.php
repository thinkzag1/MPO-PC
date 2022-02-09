<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="ccm-block-topic-list-wrapper">

    <div class="ccm-block-topic-list-header">
        <h5><?php echo h('Author List'); ?></h5>
    </div>
    
    <form name="topics-sel" id="topics-sel" method="post">
        <input type="hidden" name="form-type" value="user select">
        
        <ul class="ccm-block-topic-list-list">
        <?php
        $session = Core::make('app')->make('session');
        $session_authorFilters = unserialize($session->get('authorFilters'));
        foreach($users as $user){
            
            if(!$user->getAttribute('hide_author')){
                
            ?><li><input type="checkbox" name="authorFilter[<?php echo $user->getUserID(); ?>]" value="<?php echo $user->getUserID(); ?>" onclick="$(this).closest('form').submit();" <?php if($session_authorFilters[$user->getUserID()]){ echo 'checked="checked"';}?> > <a href="<?php echo $view->controller->getAuthorLink($user); ?>"><?php echo $user->getAttribute('full_name'); ?></a></li><?php
                
            }
        }
        ?>
        </ul>
        
    </form>
    
</div>
