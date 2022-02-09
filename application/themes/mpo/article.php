<?php
defined('C5_EXECUTE') or die("Access Denied.");

$this->inc('elements/header.php');
?>

<main class="main-att">
    <?php
    $a = new Area('Main Attorney');
    $a->enableGridContainer();
    $a->display($c);
	?>
	
		<div class="grid-att">   
			<div class="container">
				<div class="row">
					<div class="col-md-4 grid-one-att">
						<?php
						$a = new Area('Grid One Attorney');
						$a->enableGridContainer();
						$a->display($c);
						?>
					</div>
					<div class="col-md-4 grid-two-att">
						<?php
						$a = new Area('Grid Two Attorney');
						$a->enableGridContainer();
						$a->display($c);
						?>
					</div>
					<div class="col-md-4 grid-three-att">
						<?php
						$a = new Area('Grid Three Attorney');
					   $a->enableGridContainer();
						$a->display($c);
						?>
					</div>
				</div>
				<div class="row row-2">
				   <div class="col-md-4 grid-four-att">
						<?php
						$a = new Area('Grid Four Attorney');
					   $a->enableGridContainer();
						$a->display($c);
						?>
					</div>
					<div class="col-md-8 grid-five-att">
						<?php
						$a = new Area('Grid Five Attorney');
						$a->enableGridContainer();
						$a->display($c);
						?>
					</div>
				</div>
			</div>
		 </div>
		
	<div class="main-att-cont">
		<?php
		$a = new Area('Main Attorney Continued');
		$a->enableGridContainer();
		$a->display($c);
		?>
	</div>
</main>

<?php
$this->inc('elements/footer.php');