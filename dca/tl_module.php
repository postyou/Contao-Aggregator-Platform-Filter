<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist'] = str_replace(';{template_legend',',hideFacebookNews,text_only_mode,messageLength,platformFilter;{template_legend', $GLOBALS['TL_DCA']['tl_module']['palettes']['newslist']);
//$GLOBALS['TL_DCA']['tl_module']['palettes']['newsreader'] = str_replace(';{template_legend',',hideFacebookNews,text_only_mode,messageLength;{template_legend', $GLOBALS['TL_DCA']['tl_module']['palettes']['newsreader']);
//$GLOBALS['TL_DCA']['tl_module']['palettes']['newsarchive'] = str_replace(';{template_legend',',hideFacebookNews,text_only_mode,messageLength;{template_legend', $GLOBALS['TL_DCA']['tl_module']['palettes']['newsarchive']);
//$GLOBALS['TL_DCA']['tl_module']['palettes']['newsmenu'] = str_replace(';{template_legend',',hideFacebookNews,text_only_mode,messageLength;{template_legend', $GLOBALS['TL_DCA']['tl_module']['palettes']['newsmenu']);

$GLOBALS['TL_DCA']['tl_module']['fields']['platformFilter'] = array
(
    'label'	=> &$GLOBALS['TL_LANG']['tl_module']['platformFilter'],
    'inputType'	=> 'multiColumnWizard',
    'search'	=> true,
    'eval'	=> array
    (
//        'alwaysSave'	=> true,
        'tl_class'	=> 'clr',
//        'minCount'	=> 1,
        'columnFields'	=> array
        (
            'count'	=> array
            (
                'label'	=> &$GLOBALS['TL_LANG']['tl_module']['platformFilter_count'],
                'inputType'	=> 'text',
                'eval'	=> array
                (
                    'mandatory'	=> true,
//                    'tl_class'	=> 'bill_items_amount'
                ),
//                'save_callback'	=> array
//                (
//                    array('tl_hot_bills', 'items_amount_save')
//                )
            ),
            'type'	=> array
            (
                'label'	=> &$GLOBALS['TL_LANG']['tl_module']['platformFilter_type'],
                'inputType'	=> 'select',
                'options_callback'	=> array('tl_module_aggregator_platform_filter', 'typeOptionCallback'),
                'eval'	=> array
                (
                    'mandatory'	=> true,
//                    'tl_class'	=> 'bill_items_type',
//                    'submitOnChange' => true,
//                    'chosen'	=> true,
                ),
//                'save_callback'	=> array
//                (
//                    array('tl_hot_bills', 'items_type_save')
//                )
            ),
        )
    ),
    'sql'	=> "text NULL"
);

class tl_module_aggregator_platform_filter{

    public function typeOptionCallback($dc){
        \Contao\Controller::loadDataContainer("tl_news");
        $default=$GLOBALS['TL_DCA']['tl_news']['fields']['plattform']["default"];
        if(isset($default))
            $rtnArr=array($default=>$default);
        else
            $rtnArr=array();
        $res=$dc->Database->execute("SELECT DISTINCT plattform FROM tl_news")->fetchAllAssoc();
        if($res){
            foreach ($res as $platform){
               if(isset($platform["plattform"]) && !empty($platform["plattform"]))
                    $rtnArr[$platform["plattform"]]=$platform["plattform"];
            }
        }
        return $rtnArr;
    }


}