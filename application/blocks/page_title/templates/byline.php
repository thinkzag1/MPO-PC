<?php  defined('C5_EXECUTE') or die("Access Denied.");
$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
$page = Page::getCurrentPage();
$date = $dh->formatDate($page->getCollectionDatePublic(), true);
$user = UserInfo::getByID($page->getCollectionUserID());
?>
<div class="ccm-block-page-title-byline">
    <h1 class="page-title"><?php echo h($title)?></h1>

    <span class="page-date">
    <?php echo $date; ?>
    </span>

    <?php if (is_object($user)): ?>
    <span class="page-author">
    <?php
    $parent = Page::getByID($page->getCollectionParentID());
    $parentLink = $parent->getCollectionLink();
    ?>
    <a href="<?php echo $parentLink; ?>?authorFilter=<?php echo $user->getUserID(); ?>"><?php echo $user->getAttribute('full_name'); ?></a>
    </span>
    <?php endif; ?>
</div>
