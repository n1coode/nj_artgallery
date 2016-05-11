<?php
namespace N1coode\NjArtgallery\Utility;
use N1coode\NjArtgallery\Utility\Constants;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class Configuration
{
    /**
     * @var string
     */
    protected $nj_ext_namespace = Constants::NJ_EXT_NAMESPACE;

    /**
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     * @return void
     */
    public static function settings(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager)
    {
        $flexformSettingsExists = false;
        $useTypoScript = false;

        $frameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        if(array_key_exists('flexform', $frameworkConfiguration['settings']))
        {
            $flexformSettingsExists = true;
        }

        if($flexformSettingsExists)
        {
            if($frameworkConfiguration['settings']['flexform']['general']['typoScript'] == 1)
            {
                $useTypoScript = true;
            }
            else
            {
                $flexform = $frameworkConfiguration['settings']['flexform'];
                foreach($flexform['general'] as $key=>$value)
                {
                    $frameworkConfiguration['settings']['general'][$key] = $value;
                }
                foreach($flexform['persistence'] as $key=>$value)
                {
                    $frameworkConfiguration['persistence'][$key] = $value;
                }
                foreach($flexform['model'] as $key=>$value)
                {
                    $frameworkConfiguration['settings']['model'][$key] = $value;
                }

                unset($frameworkConfiguration['settings']['flexform']);
            }
        }
        else
        {
            $useTypoScript = true;
        }

        if($useTypoScript)
        {
            //nothing todo
        }

        $configurationManager->setConfiguration($frameworkConfiguration);

    } //end of function getSetup

} //end of N1coode\NjArtgallery\Utility\Configuration