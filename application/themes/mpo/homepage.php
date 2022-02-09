<?php
defined('C5_EXECUTE') or die("Access Denied.");

$this->inc('elements/header.php');
?>

<main class="main-home">
    <?php
    $a = new Area('Main');
    $a->enableGridContainer();
    $a->display($c);
	?>
		<div class="location-section">   
			<div class="container">
				<div class="row">
				   <div class="col-md-6 location-left">
						<?php
						$a = new Area('Location Left');
						$a->display($c);
						?>
					</div>
					<div class="col-md-6 location-right">
						<?php
						$a = new Area('Location Right');
						$a->display($c);
						?>
					</div>
				</div>
			</div>
	 	</div>
	 	<div class="container">
			<div class="row">
			   <div class="col-md-4">
			   </div>
				<div class="col-md-4 location-text">
					<?php
					$a = new Area('Location Text');
					$a->display($c);
					?>
				</div>
				<div class="col-md-4">
				</div>
			</div>
		</div>
</main>

<?php
$this->inc('elements/footer.php');