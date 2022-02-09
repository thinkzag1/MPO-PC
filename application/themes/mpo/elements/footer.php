<?php defined('C5_EXECUTE') or die("Access Denied.");

$footerSiteTitle = new GlobalArea('Footer Site Title');
$footerSiteTitleBlocks = $footerSiteTitle->getTotalBlocksInArea();

$footerSocial = new GlobalArea('Footer Social');
$footerSocialBlocks = $footerSocial->getTotalBlocksInArea();

$displayFirstSection = $footerSiteTitleBlocks > 0 || $footerSocialBlocks > 0 || $c->isEditMode();
?>

<footer id="footer-theme">
    <?php
    //if ($displayFirstSection) {
        ?>
        <!--<div class="main-footer-icons">
			<?php
			//$a = new Area('Main Continue');
			//$a->enableGridContainer();
			//$a->display($c);
			?>
		</div>-->
       <div class="main-footer-icons">
       		<div class="container">
  
 
					<div class="col-sm-2 footer-icon-one col-xs-offset-1">
						<?php
						$a = new GlobalArea('Footer Icon One');
						$a->display();
						?>
					</div>
					<div class="col-sm-2 footer-icon-two">
						<?php
						$a = new GlobalArea('Footer Icon Two');
						$a->display();
						?>
					</div>
					<div class="col-sm-2 footer-icon-three">
						<?php
						$a = new GlobalArea('Footer Icon Three');
						$a->display();
						?>
					</div>
					<div class="col-sm-2 footer-icon-four">
						<?php
						$a = new GlobalArea('Footer Icon Four');
						$a->display();
						?>
					</div>
				    <div class="col-sm-2 footer-icon-five">
						<?php
						$a = new GlobalArea('Footer Icon FIVE');
						$a->display();
						?>
					</div>

		   </div>
		</div>
    
        <?php
    //}
    ?>

</footer>
<footer id="footer-theme-two">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 footer-legal">
				<?php
				$a = new GlobalArea('Footer Legal');
				$a->display();
				?>
			</div>
		<div class="row">
			<div class="col-sm-3 footer-search">
				<?php
				$a = new GlobalArea('Footer Search');
				$a->display();
				?>
			</div>
			<div class="col-sm-6 footer-legal-two">
				<?php
				$a = new GlobalArea('Footer Legal Two');
				$a->display();
				?>
			</div>
			<div class="col-sm-3 footer-social">
				<?php
				$a = new GlobalArea('Footer Social');
				$a->display();
				?>
			</div>
		</div>
		</div>
	</div>
</footer>

<!--<footer id="concrete5-brand">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <span><?php echo t('Built with <a href="http://www.concrete5.org" class="concrete5" rel="nofollow">concrete5</a> CMS.') ?></span>
                <span class="pull-right">
                    <?php echo Core::make('helper/navigation')->getLogInOutLink() ?>
                </span>
                <span id="ccm-account-menu-container"></span>
            </div>
        </div>
    </div>
</footer>-->
<?php if($_SERVER['REDIRECT_URL']=='/contact/review-us'){ ?>
<style>
	input.wpcf7-form-control.wpcf7-submit{ background:#35627b; color:#fff;}
	.centeralign img{width:100%;     cursor: pointer;}
	#footer-theme{margin-top: 3em;} 
	.main-footer-icons,.hero-image{display:none;}
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 
<script src="https://parsleyjs.org/dist/parsley.min.js"></script>
<style>.bID-2380,.bID-2382{width:100%;} #myModal1 .modal-dialog{ width: 24em;} #myModal2 input,#myModal2 textarea,#myModal2 label{ width:100%;}#myModal2 textarea{max-height: 4em;}</style>
<script>
	$(document).on('click','.bID-2407',function(){  $('#myModal1').modal('show'); });
    $(document).on('click','.bID-2406',function(){  $('#myModal2').modal('show'); });
	$('#myModal2 form').parsley();
</script>
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
			<center><h3>Thank you! We need your help. Would you share your experience on one of these sites?</h3>
			<a target="_new" href="https://www.google.com/search?q=midgett+preti+olansen+virginia+beach&oq=midgett&aqs=chrome.2.69i57j35i39l2j0i457j46i175i199j69i61j69i60j69i61.6961j0j7&sourceid=chrome&ie=UTF-8#lrd=0x89baeabb0d0882f7:0x8f485d85bada5c67,3,,,"><img src="https://mpopc.com/application/files/3616/1349/2054/google1-250x100.png" alt="google"></a><br><br>
			<a target="_new" href="https://www.lawyers.com/clientrating/fillSurvey?firmId=1754449"><img src="https://mpopc.com/application/files/9416/1349/1837/badges_lawyers_com1.png" style="width:16em;" alt="badges_lawyer"></a><br><br>
			<a target="_new" href="https://www.yelp.com/writeareview/biz/SOZqH7y4G9l6m-eP9UVp8A?return_url=%2Fbiz%2FSOZqH7y4G9l6m-eP9UVp8A&source=biz_details_war_button"><img src="https://mpopc.com/application/files/3216/1349/2055/yep-review-218x140.png" alt="yep-review"></a></center>
        </div>
        
      </div>
      
    </div>
  </div>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
			<center><h3>We strive for 100% customer satisfaction. If we fell short, please tell us more so we can address your concerns.</h3></center>
          <form action="/contact/review-us?h=<?php echo rand(); ?>" method="post" class="wpcf7-form init" >
	<input type="hidden" name="formsd" value="1">
<p><label> Your Name (required)<br>
    <span class="wpcf7-form-control-wrap your-name"><input type="text" name="your-name"  size="40" class="wpcf7-form-control" required></span> </label></p>
<p><label> Your Email (required)<br>
    <span class="wpcf7-form-control-wrap your-email"><input type="email" name="your-email"  size="40" class="wpcf7-form-control" required></span> </label></p>
<p><label> Your Number (required)<br>
<span class="wpcf7-form-control-wrap tel-584"><input type="tel" name="Phone_number"  size="40" class="wpcf7-form-control"  required></span> </label></p>
<p><label> Your Message<br>
    <span class="wpcf7-form-control-wrap your-message"><textarea name="your-message" cols="40" rows="10" class="wpcf7-form-control" ></textarea></span> </label></p>

<p><input type="submit" value="Submit" class="wpcf7-form-control wpcf7-submit"></p>
</form>
        </div>
        
      </div>
      
    </div>
  </div>
<?php 
	print_r($_REQUEST);												 
if(isset($_POST['formsd'])){
	echo 'Mail';
	unset($_POST['formsd']);
	$msg='';
	foreach($_POST as $k=>$v){
		$msg.='<br>'.$k.': '.$v;
	}
	
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


 
echo 'Send:-1'.mail('anna.basurto@mpopc.com','Negative Feedback Form Received',$msg,$headers);
echo 'Send:-2'.mail('support@thinkzag.com','Negative Feedback Form Received',$msg,$headers);	
echo 'Send:-3'.mail('nikita04virag@gmail.com','Negative Feedback Form Received',$msg,$headers);	
echo 'Send:-4'.mail('ankitfriend07@gmail.com','Negative Feedback Form Received',$msg,$headers);	
}

?>



<?php } ?>
<?php $this->inc('elements/footer_bottom.php');?>
