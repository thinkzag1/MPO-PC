<?php 
/**
 * @author      shahroq <shahroq \at\ yahoo.com>
 * @copyright   Copyright (c) 2016 shahroq
 * http://concrete5.killerwhalesoft.com/addons/
 */
defined('C5_EXECUTE') or die("Access Denied.");
//print_r($carousel);
?>
<?php  if(isset($carousel) && is_object($carousel)) { ?>
    <div id="<?php  echo $carousel->containerID; ?>" class="owl-carousel <?php  echo (isset($carousel->containerClass))?$carousel->containerClass:'';?>" style="display:none;" data-version="<?php  echo $carousel->packageVersion; ?>">

        <?php  foreach ((object)$carousel->itemsObj as $key => $value) { ?>
            <div class="item" id="item-<?php  echo $value->itemID?>" style="<?php  echo (isset($value->itemStyle))?$value->itemStyle:''?>">
                <?php 
                if(strlen($value->itemImageSrc)>0){
                    if($carousel->optionsObj->lightbox){
                        printf("<a href='%s' data-lightbox-gallery='%s' title='%s'>", $value->itemImageSrcOrg, $carousel->lightboxID, $value->itemLightboxTitle);
                    }elseif ($value->itemUrlWrapper=='slide' && $value->itemUrlHref) {
                        printf("<a class='slide-link' href='%s' target='%s'>", $value->itemUrlHref, $value->itemUrlTarget);
                    }

                    if(isset($carousel->optionsObj->fullscreen) && $carousel->optionsObj->fullscreen){}else{
                        printf("<img %s='%s' alt='%s' title='%s' class='%s'/>"
                            ,$carousel->image_src_tag
                            ,$value->itemImageSrc
                            ,$value->itemImageTitle
                            ,$value->itemImageDescription
                            ,$carousel->image_class
                        );
                    }

                    if($carousel->optionsObj->lightbox){
                        printf("</a>");
                    }elseif ($value->itemUrlWrapper=='slide' && $value->itemUrlHref) {
                        printf("</a>");
                    }
                }
                
                echo "<div class='woc-caption-wrapper ".$value->captionClass."'>";
                echo "<div class='woc-caption-holder' data-animation='".$value->captionAnimation."'>";
                    if(isset($carousel->optionsObj->showTitle) && $carousel->optionsObj->showTitle){
                    if(strlen($value->itemHeader)>0){
                        printf("<%s class='item-header'>%s</%s>", $value->itemHeaderType, $value->itemHeader, $value->itemHeaderType);
                    }
                    }
                    if(isset($carousel->optionsObj->showExtraText) && $carousel->optionsObj->showExtraText){
                    if(strlen($value->itemExtraText)>0){
                        printf("<p class='item-extra-text'>%s</p><br>", $value->itemExtraText);
                    }
                    }
                    if(isset($carousel->optionsObj->showDescription) && $carousel->optionsObj->showDescription){
                    if(strlen($value->itemDescription)>0){
                        printf("<p class='item-description'>%s</p>", $value->itemDescription);
                    }
                    }
                    if ($value->itemUrlWrapper=='button' && $value->itemUrlHref) {
                        printf("<a class='item-btn' href='%s' target='%s'>%s</a>", $value->itemUrlHref, $value->itemUrlTarget, $value->itemUrlLabel);
                    }

                echo "</div>";
                echo "</div>";

                ?>
            </div>
         <?php  } ?>

    </div>

    <?php  if(isset($carousel->cssEmbed)) { ?>
        <?php  echo $carousel->cssEmbed ?>
    <?php  } ?>

    <?php  if(isset($carousel->css)) { ?>
    <style>
        <?php  echo $carousel->css ?>
    </style>
    <?php  } ?>

    <?php  if(isset($carousel->js)) { ?>
    <script type="text/javascript">
    $(document).ready(function() {
        <?php  echo $carousel->js ?>
    });
    </script>
    <?php  } ?>
<?php  } ?>