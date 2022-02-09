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
	
		<div class="grid">   
			<div class="container">
				<div class="row">
					<div class="col-md-3 grid-one">
						<?php
						$a = new Area('Grid One');
						$a->enableGridContainer();
						$a->display($c);
						?>
					</div>
					<div class="col-md-6 grid-two">
						<?php
						$a = new Area('Grid Two');
						$a->enableGridContainer();
						$a->display($c);
						?>
					</div>
					<div class="col-md-3 grid-three">
						<?php
						$a = new Area('Grid Three');
					   $a->enableGridContainer();
						$a->display($c);
						?>
					</div>
				</div>
				<div class="row row-2">
				   <div class="col-md-4 grid-four">
						<?php
						$a = new Area('Grid Four');
					   $a->enableGridContainer();
						$a->display($c);
						?>
					</div>
					<div class="col-md-6 grid-five">
						<?php
						$a = new Area('Grid Five');
						$a->enableGridContainer();
						$a->display($c);
						?>
					</div>
					<div class="col-md-2 grid-six">
						<?php
						$a = new Area('Grid Six');
					   $a->enableGridContainer();
						$a->display($c);
						?>
					</div>
				</div>
				<div class="row row-3">
				   <div class="col-md-3 grid-seven">
						<?php
						$a = new Area('Grid Seven');
					   $a->enableGridContainer();
						$a->display($c);
						?>
					</div>
					<div class="col-md-6 grid-eight">
						<?php
						$a = new Area('Grid Eight');
						$a->enableGridContainer();
						$a->display($c);
						?>
					</div>
					<div class="col-md-3 grid-nine">
						<?php
						$a = new Area('Grid Nine');
					   $a->enableGridContainer();
						$a->display($c);
						?>
					</div>
				</div>
			</div>
		 </div>
		
	<div class="main-wide-img">
		<?php
		$a = new Area('Main Wide Image');
		$a->enableGridContainer();
		$a->display($c);
		?>
	</div>
	<div class="parallax-img">
		<?php
		$a = new Area('Parallax Wide Image');
		$a->enableGridContainer();
		$a->display($c);
		?>
	</div>
		<div class="location-section">   
			<div class="container">
				<div class="row">
				   <div class="col-md-6 location-left">
						<?php
						$a = new Area('Location Left');
					    $a->enableGridContainer();
						$a->display($c);
						?>
					</div>
					<div class="col-md-6 location-right">
						<?php
						$a = new Area('Location Right');
						$a->enableGridContainer();
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
					$a->enableGridContainer();
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