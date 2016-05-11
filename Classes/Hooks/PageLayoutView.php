<?php
namespace N1coode\NjArtgallery\Hooks;
use N1coode\NjArtgallery\Service\Constants as Constants;
/**
 * @author n1coode
 * @package nj_collection
 */
class PageLayoutView implements \TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface 
{
	/**
	 * Preprocesses the preview rendering of a content element.
	 *
	 * @param PageLayoutView $parentObject Calling parent object
	 * @param boolean $drawItem Whether to draw the item using the default functionalities
	 * @param string $headerContent Header content
	 * @param string $itemContent Item content
	 * @param array $row Record row of tt_content
	 * @return void
	 */
	public function preProcess(\TYPO3\CMS\Backend\View\PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row) 
	{
		//depending on your list type!!
		if ($row['list_type'] !== Constants::NJ_EXT_LIST_TYPE) {
			return;
		}

		if(is_string($row['pi_flexform']))
		{
			$flexform = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($row['pi_flexform']);

			$controllerActions = $flexform['data']['sDEF']['lDEF']['switchableControllerActions']['vDEF'];

			if($controllerActions !== NULL)
			{
				$controllerActionsExplode = explode('->', $controllerActions);

				if(count($controllerActionsExplode === 2))
				{
					$controller = $controllerActionsExplode[0];
					$action = $controllerActionsExplode[1];
					$headerContent = '<b>'.$controller.' :: '.$action.'</b><br/>'.Constants::NJ_EXT_PATH.'<br/>';
				}
			}
		}
		else
		{
			$headerContent = '<b>'.Constants::NJ_EXT_PATH.'</b></br>';
		}
		
        $drawItem = FALSE;

        //we are in a Hook, make instance by your own pls ^^//
        /** @var $extbaseObjectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
        $extbaseObjectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        $itemContent.= '';
	}
  
	function XMLToArray($xml) {
		$parser = xml_parser_create('ISO-8859-1'); // For Latin-1 charset
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); // Dont mess with my cAsE sEtTings
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); // Dont bother with empty info
		xml_parse_into_struct($parser, $xml, $values);
		xml_parser_free($parser);

		$return = array(); // The returned array
		$stack = array(); // tmp array used for stacking
	
		foreach($values as $val) {
			if($val['type'] == "open") { array_push($stack, $val['tag']); } 
			elseif($val['type'] == "close") { \array_pop($stack); } 
			elseif($val['type'] == "complete") {
				array_push($stack, $val['tag']);
				$this->setArrayValue($return, $stack, $val['value']);
				array_pop($stack);
			}//if-elseif
		}//foreach
		
		return $return;
		
	}//function XMLToArray

	function setArrayValue(&$array, $stack, $value) {
		if ($stack) {
			$key = array_shift($stack);
			$this->setArrayValue($array[$key], $stack, $value);
			return $array;
		} else {
			$array = $value;
		}//if-else
	}//function setArrayValue
}