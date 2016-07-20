<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Aggregator;

use Contao\Model\Collection;


/**
 * Reads and writes news
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class NewsModelAggregatorWithPlatformFilter extends NewsModelAggregator
{

	public static function findPublishedByPidsWithTypeFilter($arrPids, $blnFeatured=null, $intLimit=0, $intOffset=0, array $arrOptions=array(),$textOnlyMode=false,$typefilterArr=array())
	{
		if (!is_array($arrPids) || empty($arrPids))
		{
			return null;
		}

		$t = static::$strTable;
		$arrColumns = array("$t.pid IN(" . implode(',', array_map('intval', $arrPids)) . ") AND ( headline!='' OR teaser!='') ");
        if($textOnlyMode){
            $arrColumns[]="(type!='photo' OR teaser!='')";
        }

		if ($blnFeatured === true)
		{
			$arrColumns[] = "$t.featured=1";
		}
		elseif ($blnFeatured === false)
		{
			$arrColumns[] = "$t.featured=''";
		}

		// Never return unpublished elements in the back end, so they don't end up in the RSS feed
		if (!BE_USER_LOGGED_IN || TL_MODE == 'BE')
		{
			$time = time();
			$arrColumns[] = "($t.start='' OR $t.start<$time) AND ($t.stop='' OR $t.stop>$time) AND $t.published=1";
		}

		if (!isset($arrOptions['order']))
		{
			$arrOptions['order']  = "$t.date DESC";
        }

        //$arrOptions['limit']  = $intLimit;
        //$arrOptions['offset'] = $intOffset;


        if(isset($typefilterArr) && !empty($typefilterArr) ) {
            $models=array();
            foreach ($typefilterArr as $filterArr){
                $queryArr=$arrColumns;
                $queryArr[]="$t.plattform='".$filterArr["type"]."'";
                $modelTmpColl=static::findBy($queryArr, null, array("limit"=>intval($filterArr["count"]),'order'=>$arrOptions['order']));
                if($modelTmpColl) {
                    $models=array_merge($models,$modelTmpColl->getModels());

                }
            }
            return new Collection($models,"tl_news");
        }
        return static::findBy($arrColumns, null, $arrOptions);
    }
}
