<?php
defined('C5_EXECUTE') or die("Access Denied.");

$this->inc('elements/header.php');

?>

<main>
	<div class="hero-image">
		<?php
		$a = new Area('Hero Image');
		$a->enableGridContainer();
		$a->display($c);
		?>
	</div>
    <?php
    $a = new Area('Main');
    $a->enableGridContainer();
    $a->display($c);

    $a = new Area('Page Footer');
    $a->enableGridContainer();
    $a->display($c);
    ?>
</main>

<?php
$this->inc('elements/footer.php');
