<?php
namespace N1coode\NjArtgallery\Hooks;
/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * AutoConfiguration-Hook for RealURL
 *
 */
class RealUrlAutoConfiguration
{
    /**
     * Generates additional RealURL configuration and merges it with provided configuration
     *
     * @param       array $params Default configuration
     * @return      array Updated configuration
     */
    public function addConfig($params)
    {
		$hallo = 'welt';
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($hallo);
        // Check for proper unique key
        $postVar = 'tx_njartgallery';
		
        return array_merge_recursive($params['config'], [
			'postVarSets' => [
				'_DEFAULT' => [
					$postVar => [
						[
							'GETvar' => 'tx_njartgallery_pi1[artist]',
							'lookUpTable' => [
								'table' => 'tx_njartgallery_domain_model_artist',
								'id_field' => 'uid',
								'alias_field' => 'last_name',
								'useUniqueCache' => 1,
								'useUniqueCache_conf' => [
									'strtolower' => 1,
									'spaceCharacter' => '_',
								],
							],
						],
					],
				]
			]
		]);
    }
}