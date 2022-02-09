<?php   defined('C5_EXECUTE') or die("Access Denied.");
$values[1] = (!$values[1]) ? array() : $values[1];
$values[2] = (!$values[2]) ? array() : $values[2];
?>
<select name="pageAttributesUsedForFilter[<?php   echo $pageAttributeKeyID; ?>][filterSelection]"
        class="pageAttributeInitialSelector form-control">
    <option
        value="not_empty" <?php   if ($filterSelection == 'not_empty') print 'selected'; ?>><?php   echo t('is not empty'); ?></option>
    <option
        value="is_empty" <?php   if ($filterSelection == 'is_empty') print 'selected'; ?>><?php   echo t('is empty'); ?></option>
    <option
        value="matches_all" <?php   if ($filterSelection == 'matches_all') print 'selected'; ?>><?php   echo t('matches the current page'); ?></option>
    <option
        value="not_matches_all" <?php   if ($filterSelection == 'not_matches_all') print 'selected'; ?>><?php   echo t('does not match the current page'); ?></option>
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
<div class="pageAttributeAdditionalValueSelection"
     style="margin-top:5px;<?php   echo(in_array($filterSelection, array('not_empty', 'is_empty', 'matches_all', 'not_matches_all')) ? "display:none;" : ""); ?>">
    <input class="pageAttributeAdditionalValueSelection_distance"
           name="pageAttributesUsedForFilter[<?php   echo $pageAttributeKeyID; ?>][val1]"
           value="<?php   echo $values[0]; ?>" style="width:150px;"
           title="<?php   t('A comma-separated list of distance values from which the visitor can choose'); ?>">
    <select class="pageAttributeAdditionalValueSelection_measurement"
            name="pageAttributesUsedForFilter[<?php   echo $pageAttributeKeyID; ?>][val2][measurement]"
            style="width:100px;">
        <option value="miles" <?php  
        if ($values[1]['measurement'] == 'miles') {
            print 'selected';
        }
        ?>><?php   echo t('miles'); ?></option>
        <option value="kilometers" <?php  
        if ($values[1]['measurement'] == 'kilometers') {
            print 'selected';
        }
        ?>><?php   echo t('kilometers'); ?></option>
    </select>
</div>
<div class="pageAttributeDefaultValueSelection"
     style="margin-top:5px;<?php   echo(in_array($filterSelection, array('not_empty', 'is_empty', 'matches_all', 'not_matches_all')) ? "display:none;" : ""); ?>">

    <select class="pageAttributeDefaultValueSelection_distance"
            name="searchDefaults[<?php   echo $pageAttributeKeyID; ?>][distance]" style="width:75px;">
        <option value="<?php   echo $values[2]['distance']; ?>"><?php   echo $values[2]['distance']; ?></option>
    </select>
    <span class="pageAttributeDefaultValueSelection_measurement"></span>
    of
    <select class="pageAttributeDefaultValueSelection_location"
            name="searchDefaults[<?php   echo $pageAttributeKeyID; ?>][location]" style="width:125px;">
        <option
            value="current_page" <?php   if ($values[2]['location'] == 'current_page') print 'selected'; ?>><?php   echo t('current page'); ?></option>
        <option
            value="current_location" <?php   if ($values[2]['location'] == 'current_location') print 'selected'; ?>><?php   echo t('current location'); ?></option>
        <option
            value="zip_code" <?php   if ($values[2]['location'] == 'zip_code') print 'selected'; ?>><?php   echo t('zip code'); ?></option>
    </select>
    <input class="pageAttributeDefaultValueSelection_zip_code"
           name="searchDefaults[<?php   echo $pageAttributeKeyID; ?>][zip_code]"
           value="<?php   echo $values[2]['zip_code']; ?>" style="width:75px;" placeholder="<?php   echo t('Zip Code'); ?>">
</div>
