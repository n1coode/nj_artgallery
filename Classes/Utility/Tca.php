<?php
namespace N1coode\NjArtgallery\Utility;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class Tca
{
    public function getL18nParent($config)
    {	
        $optionList = array();

        if($config['row']['l18n_parent'] > 0)
        {
            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                'uid,title',
                $config['table'],
                'pid IN ('.$config['row']['pid'].') AND uid IN ('.$config['row']['l18n_parent'].')',
                '',
                '',
                ''
            );
            while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
            {
                $optionList[] = array(0 => $row['title'], 1 => $row['uid']);
            }
        }

        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
            'uid,title',
            $config['table'],
            'pid IN ('.$config['row']['pid'].') AND sys_language_uid IN (0,-1)',
            '',
            '',
            ''
        );

        $items = array();
        while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) 
        {
            $items[] = array('title' => $row['title'], 'uid' => $row['uid']);
        }

        foreach($items as $item)
        {
            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                'uid',
                $config['table'],
                'pid IN ('.$config['row']['pid'].') AND l18n_parent IN ('.$item['uid'].')',
                '',
                '',
                ''
            );

            if($GLOBALS['TYPO3_DB']->sql_num_rows($res) < 1)
            {
                $optionList[] = array(0 => $item['title'], 1 => $item['uid']);
            }
        }
        $config['items'] = array_merge($config['items'], $optionList);
        
        return $config;

    } //end of function getL18nParent
	
    
    public function infoText($PA, $fObj)
    {
        $formField  =	'<div class="typo3-message message-information">';
        $formField .= 	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($PA['parameters']['text'], 'nj_internship');
        $formField .=	'</div>';

        return $formField;

    } //end of function infoText
	 
	 
    public function isMultiLingual($PA, $fObj) 
    {
        $tmp = 0;

        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
            'uid',
            'sys_language',
            'hidden IN (0)',
            '',
            '',
            ''
        );

        if($GLOBALS['TYPO3_DB']->sql_num_rows($res) > 0) $tmp = 1;

        return $tmp;
    }
	 
    /**
     * 
     * @param type $PA
     * @param type $fObj
     */
    public function selectOptionsIcons($config)
    {
        $icons = array(
            'adjust',
            'archive',
            'area-chart',
            'arrows',
            'arrows-h',
            'arrows-v',
            'asterisk',
            'at',
            'automobile',
            'ban',
            'bank',
            'bar-chart',
            'bar-chart-o',
            'barcode',
            'bars',
            'bed',
            'beer',
            'bell',
            'bell-o',
            'bell-slash',
            'bell-slash-o',
            'bicycle',
            'binoculars',
            'birthday-cake',
            'bolt',
            'bomb',
            'book',
            'bookmark',
            'bookmark-o',
            'briefcase',
            'bug',
            'building',
            'building-o',
            'bullhorn',
            'bullseye',
            'bus',
            'cab',
        );
        
        $optionList = array();
        foreach($icons as $icon)
        {
            $optionList[] = array(0 => ucfirst($icon), 1 => 'fa fa-'.$icon);
        }
        
        $config['items'] = array_merge($config['items'], $optionList);
        return $config;  
         
    } //end of function selectOptionsIcons
    
    function fontAwesomeIconList($PA, $fObj) 
    {
       // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($PA['row']['icon']);
        $icons = array(
            'adjust',
            'ambulance',
            'archive',
            'area-chart',
            'arrows',
            'arrows-h',
            'arrows-v',
            'asterisk',
            'at',
            'automobile',
            'ban',
            'bank',
            'bar-chart',
            'barcode',
            'bars',
            'bed',
            'beer',
            'bell',
            'bell-slash',
            'bicycle',
            'binoculars',
            'birthday-cake',
            'bolt',
            'bomb',
            'book',
            'bookmark',
            'briefcase',
            'bug',
            'building',
            'bullhorn',
            'bullseye',
            'bus',
            'cab',
            'calculator',
            'calendar',
            'camera',
            'camera-retro',
            'car',
            'cart-arrow-down',
            'cart-plus',
            'cc',
            'certificate',
            'check',
            'check-circle',
            'check-square',
            'child',
            'circle',
            'circle-thin',
            'close',
            'cloud',
            'cloud-download',
            'cloud-upload',
            'code',
            'code-fork',
            'coffee',
            'cog',
            'cogs',
            'comment',
            'comments',
            'compass',
            'copyright',
            'credit-card',
            'crop',
            'crosshairs',
            'cube',
            'cubes',
            'cutlery',
            'dashboard',
            'database',
            'desktop',
            'diamond',
            'download',
            'edit',
            'ellipsis-h',
            'ellipsis-v',
            'envelope',
            'envelope-square',
            'eraser',
            'exchange',
            'exclamation',
            'exclamation-circle',
            'exclamation-triangle',
            'external-link',
            'external-link-square',
            'eye',
            'eye-slash',
            'eyedropper',
            'fax',
            'female',
            'fighter-jet',
            'file',
            'file-text',
            'film',
            'filter',
            'fire',
            'fire-extinguisher',
            'flag',
            'flag-checkered',
            'flash',
            'flask',
            'folder-open',
            'gamepad',
            'gavel',
            'gear',
            'gears',
            'genderless',
            'gift',
            'glass',
            'globe',
            'graduation-cap',
            'group',
            'headphones',
            'heart',
            'heartbeat',
            'history',
            'home',
            'hotel',
            'image',
            'inbox',
            'info',
            'info-circle',
            'institution',
            'key',
            'language',
            'laptop',
            'leaf',
            'legal',
            'level-down',
            'level-up',
            'life-bouy',
            'life-buoy',
            'life-ring',
            'life-saver',
            'line-chart',
            'location-arrow',
            'lock',
            'magic',
            'magnet',
            'mail-forward',
            'mail-reply',
            'mail-reply-all',
            'male',
            'map-marker',
            'microphone',
            'microphone-slash',
            'minus',
            'minus-circle',
            'minus-square',
            'mobile',
            'mobile-phone',
            'money',
            'mortar-board',
            'motorcycle',
            'music',
            'navicon',
            'paint-brush',
            'paper-plane',
            'paw',
            'pencil',
            'pencil-square',
            'phone',
            'phone-square',
            'photo',
            'pie-chart',
            'plane',
            'plug',
            'plus',
            'plus-circle',
            'plus-square',
            'power-off',
            'print',
            'puzzle-piece',
            'qrcode',
            'question',
            'question-circle',
            'quote-left',
            'quote-right',
            'random',
            'recycle',
            'refresh',
            'remove',
            'reorder',
            'reply',
            'reply-all',
            'retweet',
            'road',
            'rocket',
            'rss',
            'rss-square',
            'search',
            'search-minus',
            'search-plus',
            'send',
            'server',
            'share',
            'share-alt',
            'share-alt-square',
            'share-square',
            'shield',
            'ship',
            'shopping-cart',
            'sign-in',
            'sign-out',
            'signal',
            'sitemap',
            'sliders',
            'sort',
            'sort-alpha-asc',
            'sort-alpha-desc',
            'sort-amount-asc',
            'sort-amount-desc',
            'sort-asc',
            'sort-desc',
            'sort-down',
            'sort-numeric-asc',
            'sort-numeric-desc',
            'sort-up',
            'space-shuttle',
            'spinner',
            'spoon',
            'square',
            'star',
            'star-half',
            'star-half-empty',
            'star-half-full',
            'street-view',
            'subway',
            'suitcase',
            'support',
            'tablet',
            'tachometer',
            'tag',
            'tags',
            'tasks',
            'taxi',
            'terminal',
            'thumb-tack',
            'thumbs-down',
            'thumbs-up',
            'ticket',
            'times',
            'times-circle',
            'tint',
            'toggle-down',
            'toggle-left',
            'toggle-off',
            'toggle-on',
            'toggle-right',
            'toggle-up',
            'train',
            'trash',
            'tree',
            'trophy',
            'truck',
            'tty',
            'umbrella',
            'university',
            'unlock',
            'unlock-alt',
            'unsorted',
            'user',
            'user-plus',
            'user-secret',
            'users',
            'video-camera',
            'volume-down',
            'volume-off',
            'volume-up',
            'warning',
            'wheelchair',
            'wifi',
            'wrench',
        );
        
        $formField  = '<div id="n1iconList" class="clearfix">';
       
        //$formField .= 	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($PA['parameters']['text'], 'nj_internship');
       
        foreach($icons as $icon)
        {
            $formField .= '<div name="'.$icon.'"';
            
            if('fa-'.$icon === $PA['row']['icon'])
            {
                $formField .= ' class="selected"';
            }
            
            $formField .= '><i class="fa fa-'.$icon.' fa-3x';

            $formField .= '"></i>'.$icon.'</div>';
        }
        
        $formField .=	'</div>';
       
        $formField .= '<script>';
        $formField .= '
            (function($) 
            {
                $(function() 
                {
                    $(document).ready(function()
                    {
                        $("#n1iconList > DIV").click(function()
                        {
                            if(!$(this).hasClass("selected"))
                            {
                                $("input[name*=icon]").val("fa-"+$(this).attr("name")); 

                                typo3form.fieldGet("data[tx_njinternship_domain_model_direction][1][icon]","trim","",0,"");
                                TBE_EDITOR.fieldChanged("tx_njinternship_domain_model_direction","1","icon","data[tx_njinternship_domain_model_direction][1][icon]");

                                $("#n1iconList > DIV").each(function() {
                                    $(this).removeClass("selected");
                                });
                                $(this).addClass("selected");
                            }
                        });

                    });
                });
            })(TYPO3.jQuery);
        ';
        $formField .= '</script>';
        
        $formField .= '<link rel="stylesheet" type="text/css" href="../typo3conf/ext/nj_internship/Resources/Public/Css/Lib/font-awesome/4.3.0/css/font-awesome.min.css"></link>';
        $formField .= '<style>'
            . '#n1iconList > DIV { font-size: 10px; float: left; margin-right: 10px; text-align: center; width: 100px; margin-bottom: 10px; padding: 5px; } '
            . '#n1iconList > DIV:hover { background-color: #999999; color:black; cursor: pointer; } '
            . '.selected, .selected:hover { background-color: #222222 !important; color:#efefef !important; } '
            . '.selected, #n1iconList > DIV:hover { -webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px; } '
            . '.selected:hover { cursor:default !important; }'
            . '.fa{display:block; text-align:center; }'
            . '</style>';
        
        return $formField;
    }
    
} //end of class Tca

?>

    
     