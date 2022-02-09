<?php  

namespace Concrete\Package\SkybluesofaPageListPlus\Src\PageListPlus\Filter\Service;

use Package;
use Environment;
use Concrete\Package\SkybluesofaPageListPlus\Src\PageListPlus\Filter\Filter;

defined('C5_EXECUTE') or die("Access Denied.");

class Finder
{
    public static function getFilterHtml($pageAttribute)
    {
        $returnValue = array('path' => null, 'packageHandle' => null);
        $packageHandles = self::getPackageHandles($pageAttribute);
        $attributeFilterViewFilePath = DIRNAME_ELEMENTS . '/blocks/page_list_plus/form/filters/' . $pageAttribute->getAttributeTypeHandle() . '.php';

        foreach ($packageHandles as $packageHandle) {
            $attributeFilterViewFile = Environment::get()->getPath($attributeFilterViewFilePath, $packageHandle);
            if (file_exists($attributeFilterViewFile)) {
                $returnValue['path'] = 'blocks/page_list_plus/form/filters/' . $pageAttribute->getAttributeTypeHandle();
                $returnValue['packageHandle'] = $packageHandle;
                return $returnValue;
            }
        }
    }

    private function getPackageHandles($attribute)
    {
        $packageHandles = array();
        $filter = Filter::getByHandle($attribute->atHandle);
        if ($filter) {
            $packageHandles[] = Package::getByID($filter->getPackageId())->getPackageHandle();
        }
        $packageHandles[] = $attribute->getPackageHandle();
        $packageHandles[] = 'skybluesofa_page_list_plus';
        return $packageHandles;
    }

    public static function getSearchHtml($searchFilter)
    {
        $returnValue = array('path' => null, 'packageHandle' => null);
        $packageHandles = self::getPackageHandles($searchFilter);
        $attributeSearchViewFilePath = DIRNAME_ELEMENTS . '/blocks/page_list_plus/search/filters/' . $searchFilter->getAttributeTypeHandle() . '.php';
        foreach ($packageHandles as $packageHandle) {
            if ($packageHandle == 'skybluesofa_page_list_plus') {
                if (in_array($searchFilter->getAttributeTypeHandle(), array('text', 'textarea', 'number', 'rating', 'image_file', 'page_selector'))) {
                    $attributeSearchViewFilePath = 'blocks/page_list_plus/search/filters/single_option';
                } elseif (in_array($searchFilter->getAttributeTypeHandle(), array('topics'))) {
                    $attributeSearchViewFilePath = 'blocks/page_list_plus/search/filters/topics';
                } elseif (in_array($searchFilter->getAttributeTypeHandle(), array('boolean', 'select'))) {
                    $attributeSearchViewFilePath = 'blocks/page_list_plus/search/filters/multiple_option';
                } elseif (in_array($searchFilter->getAttributeTypeHandle(), array('date_time', 'multi_date'))) {
                    $attributeSearchViewFilePath = 'blocks/page_list_plus/search/filters/date';
                }
            }

            $attributeSearchViewFile = Environment::get()->getPath(DIRNAME_ELEMENTS.'/'.$attributeSearchViewFilePath.'.php', $packageHandle);
            if (file_exists($attributeSearchViewFile)) {
                $returnValue['path'] = $attributeSearchViewFilePath;
                $returnValue['packageHandle'] = $packageHandle;
                return $returnValue;
            }
        }
    }
}