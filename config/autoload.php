<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Aggregator',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Src
	'Aggregator\NewsModelAggregatorWithTypeFilter'      => 'system/modules/aggregator_type_filter/src/NewsModelAggregatorWithTypeFilter.php',
	'Aggregator\ModuleNewsListAggregatorWithTypeFilter' => 'system/modules/aggregator_type_filter/src/ModuleNewsListAggregatorWithTypeFilter.php',
));
