<?php defined('C5_EXECUTE') or die("Access Denied.");
$url=$_SERVER['REQUEST_URI'];
//echo $url;
if($url=='/download_file/view/413/413')
{
	//header('Location: https://mpopc.com');
	echo "<script>window.location.href='https://mpopc.com';</script>";
}
if($url=='/blog/personal_liability_for_debts_of_a_deceased_family_member')
{
	
  //header('Location: https://mpopc.com/blog/personal-liability-for-debts-of-a-deceased-family-member',true,302);
	echo "<script>window.location.href='https://mpopc.com/blog/personal-liability-for-debts-of-a-deceased-family-member';</script>";
}
if($url=='/download_file/view/408/408')
{
  //header('Location: https://mpopc.com');
	echo "<script>window.location.href='https://mpopc.com';</script>";
}
if($url=='/download_file/view/408/408r')
{
  //header('Location: https://mpopc.com');
	echo "<script>window.location.href='https://mpopc.com';</script>";
}
$this->inc('elements/header_top.php');
$as = new GlobalArea('Header Search');
$blocks = $as->getTotalBlocksInArea();
$displayThirdColumn = $blocks > 0 || $c->isEditMode();
?>

<header>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-xs-6 logo">
                <?php
                $a = new GlobalArea('Header Site Title');
                $a->display();
                ?>
            </div>
            <div class="col-sm-8 col-xs-6 site-nav">
                <?php
                $a = new GlobalArea('Header Navigation');
                $a->display();
                ?>
            </div>
        </div>
    </div>
</header>

