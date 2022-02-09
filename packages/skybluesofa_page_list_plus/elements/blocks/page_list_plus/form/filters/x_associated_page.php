<?php   defined('C5_EXECUTE') or die("Access Denied.");

Loader::model('attribute/types/associated_page/controller', 'skybluesofa_page_association_attribute');
$ak = CollectionAttributeKey::getByHandle($pageAttribute->getAttributeKeyHandle());
$apatc = new AssociatedPageAttributeTypeController(AttributeType::getByID($pageAttribute->atID));
$apatc->setAttributeKey($ak);
$values = $apatc->getCheckedPages();
?>
<select name="pageAttributesUsedForFilter[<?php   echo $pageAttributeKeyID; ?>][filterSelection]"
        class="pageAttributeInitialSelector form-control">
    <option
        value="not_empty" <?php   if ($filterSelection == 'not_empty') print 'selected'; ?>><?php   echo t('is not empty'); ?></option>
    <option
        value="is_empty" <?php   if ($filterSelection == 'is_empty') print 'selected'; ?>><?php   echo t('is empty'); ?></option>
    <option value="equals" <?php   if ($filterSelection == 'equals') print 'selected'; ?>><?php   echo t('is'); ?></option>
    <option
        value="not_equals" <?php   if ($filterSelection == 'not_equals') print 'selected'; ?>><?php   echo t('is not'); ?></option>
    <option
        value="matches_all" <?php   if ($filterSelection == 'matches_all') print 'selected'; ?>><?php   echo t('matches the current page'); ?></option>
    <option
        value="not_matches_all" <?php   if ($filterSelection == 'not_matches_all') print 'selected'; ?>><?php   echo t('does not match the current page'); ?></option>
</select>
<div class="pageAttributeAdditionalValueSelection"
     style="margin-top:5px;<?php   echo(in_array($filterSelection, array('not_empty', 'is_empty', 'matches_all', 'querystring_all', 'matches_any', 'querystring_any', 'not_matches_all', 'not_querystring_all')) ? "display:none;" : ""); ?>">
    <select name="pageAttributesUsedForFilter[<?php   echo $pageAttributeKeyID; ?>][val1]" class="form-control">
        <?php  
        if ($values->count() == 0) {
            ?>
            <option value=""> - <?php   echo t('No options are currently available'); ?> -</option>
        <?php  
        } else {
            foreach ($values as $cId => $cTitle) {
                ?>
                <option
                    value="<?php   echo $cId; ?>" <?php   if ($values[0] == $cId) print 'selected'; ?>><?php   echo $cTitle; ?></option>
            <?php  
            }
        }
        ?>
    </select>
</div>
<div class="pageAttributeDefaultValueSelection"
     style="margin-top:5px;<?php   echo(in_array($filterSelection, array($values[0], 'querystring_any', 'querystring_all', 'not_querystring_all', 'less_than_querystring', 'less_than_or_equal_to_querystring', 'more_than_querystring', 'more_than_or_equal_to_querystring')) ? "" : "display:none;"); ?>">
    <select name="searchDefaults[<?php   echo $pageAttributeKeyID; ?>]" class="form-control">
        <?php  
        if ($values->count() == 0) {
            ?>
            <option value=""> - <?php   echo t('No options are currently available'); ?> -</option>
        <?php  
        } else {
            foreach ($values as $cId => $cTitle) {
                ?>
                <option
                    value="<?php   echo $cId; ?>" <?php   if ($values[2] == $cId) print 'selected'; ?>><?php   echo $cTitle; ?></option>
            <?php  
            }
        }
        ?>
    </select>
</div>