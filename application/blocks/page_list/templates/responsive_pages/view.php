<?php
defined('C5_EXECUTE') or die("Access Denied.");
$th = Loader::helper('text');
$c = Page::getCurrentPage();
?>

<div class="search-practice-result clearfix">
	<div class="col-sm-3 search-practice-list">
		<?php
		foreach ($pages as $page) { 
			$title = $th->entities($page->getCollectionName());
			$url = $nh->getLinkToCollection($page);
			$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
			$target = empty($target) ? '_self' : $target;
			?>
		<a href="<?php echo $url ?>" target="<?php echo $target ?>"><?php echo $title; ?></a>
		<?php
		}
		?>
	</div>

    <?php if (isset($pageListTitle) && $pageListTitle): ?>
        <div class="ccm-block-page-list-header">
            <h5><?php echo h($pageListTitle)?></h5>
        </div>
    <?php endif; ?>

    <?php foreach ($pages as $page):

        $title = $th->entities($page->getCollectionName());
        $url = $nh->getLinkToCollection($page);
        $target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
        $target = empty($target) ? '_self' : $target;
        $thumbnail = $page->getAttribute('thumbnail');
        $hoverLinkText = $title;
        $description = $page->getCollectionDescription();
        $description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
        $description = $th->entities($description);
        if ($useButtonForLink) {
            $hoverLinkText = $buttonLinkText;
        }

        ?>

        <div class="search-practice-overview-item col-sm-9">
			<div class="search-practice-overview-item-title">
				<a href="<?php echo $url ?>" target="<?php echo $target ?>"><?php echo $title; ?></a>
			</div>

			<?php if ($includeDate): ?>
				<div class="ccm-block-page-list-date"><?php echo $date?></div>
			<?php endif; ?>

			<?php if ($includeDescription): ?>
				<div class="search-practice-overview-item-text">
					<?php echo $description ?>
				</div>
			<?php endif; ?>

        <?php if (is_object($thumbnail)): ?>
            <div class="ccm-block-page-list-page-entry-grid-thumbnail">
                <a href="<?php echo $url ?>" target="<?php echo $target ?>"><?php
                $img = Core::make('html/image', array($thumbnail));
                $tag = $img->getTag();
                $tag->addClass('img-responsive');
                echo $tag;
                ?>
                </a>

            </div>
        <?php endif; ?>

        </div>

	<?php endforeach; ?>

    <?php if (count($pages) == 0): ?>
        <div class="ccm-block-page-list-no-pages"><?php echo h($noResultsMessage)?></div>
    <?php endif;?>

</div>

<?php if ($showPagination): ?>
    <?php echo $pagination;?>
<?php endif; ?>

<?php if ($c->isEditMode() && $controller->isBlockEmpty()): ?>
    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Page List Block.')?></div>
<?php endif; ?>

<script>
$(function(){
	$('.search-practice-list>a').bind('mouseenter', function(){
		var idx =  $(this).index();
		
		// hide all item boxes
		$('.search-practice-overview-item').hide();
		
		// show selected box
		$('.search-practice-overview-item').eq(idx).show();
	});
	
	// show initial box
	$('.search-practice-overview-item').eq(0).show();
});
</script>