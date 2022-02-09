<?php 
/**
 * @author 		shahroq <shahroq \at\ yahoo.com>
 * @copyright  	Copyright (c) 2015 shahroq.
 * http://concrete5.killerwhalesoft.com/addons/
 */
defined('C5_EXECUTE') or die("Access Denied.");
$fh = Loader::helper('form');
?>

<div class="whale-ui ccm-ui" style="height: 100%">
    
    <?php   if(isset($carouselList) && count($carouselList)>0){ ?>
    <div class="form-group well" style="height: 100%;">
        <label><?php   echo t('Select a Carousel')?>:</label>
        <?php   echo $fh->select('carouselID', $carouselList, $carouselID); ?>
    </div>
    <?php   } ?>

    <span class="label label-default" style="padding:5px 7px;">
        <?php  echo t("Create more <a href='%s' target='_blank'>here</a>", BASE_URL."/index.php/dashboard/files/whale_owl_carousel/") ?>
    </span>

</div>