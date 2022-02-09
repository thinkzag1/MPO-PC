<?php
defined('C5_EXECUTE') or die("Access Denied.");

$this->inc('elements/header.php');
?>

<main class="main-att">
	<div class="att-name">
		<?php
		$a = new Area('Attorney Name');
		$a->enableGridContainer();
		$a->display($c);
		?>
	</div>
	<div class="att-contact">
		<?php
		$a = new Area('Attorney Contact');
		$a->enableGridContainer();
		$a->display($c);
		?>
	</div>
	
		<div class="grid grid-att">   
			<div class="container">
				<div class="row">
					<div class="col-md-3 grid-one-att">
						<?php
						$a = new Area('Grid One Attorney');
						$a->enableGridContainer();
						$a->display($c);
						?>
						<?php
						$a = new Area('Grid Four Attorney');
					    $a->enableGridContainer();
						$a->display($c);
						?>
					</div>
					<div class="col-md-9 grid-two-att">
						<?php
						$a = new Area('Grid Two Attorney');
						$a->enableGridContainer();
						$a->display($c);
						?>
					</div>
					<!--<div class="col-md-4 grid-three-att">
						<?php
						//$a = new Area('Grid Three Attorney');
					    //$a->enableGridContainer();
						//$a->display($c);
						?>
					</div>-->
				</div>
				<div class="row row-2">
				   <!--<div class="col-md-3 grid-four-att">
						<?php
						//$a = new Area('Grid Four Attorney');
					    //$a->enableGridContainer();
						//$a->display($c);
						?>
					</div>-->
					<div class="col-md-12 grid-five-att">
						<?php
						$a = new Area('Grid Five Attorney');
						$a->enableGridContainer();
						$a->display($c);
						?>
					</div>
				</div>
			</div>
		 </div>
		
	<!--<div class="articles-pres">
		<?php
		//$a = new Area('Articles Presentations');
		//$a->enableGridContainer();
		//$a->display($c);
		?>
	</div>
	<div class="main-att-body">
		<?php
		//$a = new Area('Main Attorney Body');
		//$a->enableGridContainer();
		//$a->display($c);
		?>
	</div>-->
	<div class="extra-section-one">
		<?php
		$a = new Area('Extra Section One');
		$a->enableGridContainer();
		$a->display($c);
		?>
	</div>
	<div class="extra-section-two">
		<?php
		$a = new Area('Extra Section Two');
		$a->enableGridContainer();
		$a->display($c);
		?>
	</div>
</main>

<?php
$this->inc('elements/footer.php');