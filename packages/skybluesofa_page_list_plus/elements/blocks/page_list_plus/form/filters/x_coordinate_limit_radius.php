<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<select name="pageAttributesUsedForFilter[<?php   echo $pageAttributeKeyID; ?>][filterSelection]"
        class="pageAttributeInitialSelector form-control">
    <option
        value="not_empty" <?php   if ($filterSelection == 'not_empty') print 'selected'; ?>><?php   echo t('is not empty'); ?></option>
    <option
        value="is_empty" <?php   if ($filterSelection == 'is_empty') print 'selected'; ?>><?php   echo t('is empty'); ?></option>
    <option
        value="within_distance_match" <?php   if ($filterSelection == 'within_distance_match') print 'selected'; ?>><?php   echo t('within distance of the current page'); ?></option>
    <option
        value="not_within_distance_match" <?php   if ($filterSelection == 'not_within_distance_match') print 'selected'; ?>><?php   echo t('not within distance of the current page'); ?></option>
    <?php   if (!$disallowSearch) { ?>
        <option
            value="within_distance_querystring" <?php   if ($filterSelection == 'within_distance_querystring') print 'selected'; ?>
            class="sbs_plp_searchValue"><?php   echo t('within distance of the search value'); ?></option>
        <option
            value="not_within_distance_querystring" <?php   if ($filterSelection == 'not_within_distance_querystring') print 'selected'; ?>
            class="sbs_plp_searchValue"><?php   echo t('not within distance of the search value'); ?></option>
    <?php   } ?>
</select>
