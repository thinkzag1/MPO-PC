<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 
if(count($items)<1){ ?>
    <div class="well"><?php echo t('You did not add any items to the accordion.')?></div>
<?php  } else { ?>
<div class="vivid-simple-accordion" id="vivid-simple-accordion-<?php echo $bID?>">
    <?php  foreach($items as $item){?>
    <div class="simple-accordion-group <?php echo $item['state']?>">
        <div class="simple-accordion-title-shell">
            <?php echo $openTag?><?php echo $item['title']?><?php echo $closeTag?>
        </div>
        <div class="simple-accordion-description">
            <?php echo $item['description']?>
        </div>
    </div>
    <?php  } ?>
</div>
<?php  } ?>
