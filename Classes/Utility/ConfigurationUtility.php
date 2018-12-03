<?php
declare(strict_types=1);
namespace Pixelant\PxaResultifyBeloginNews\Utility;

/*
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

/**
 * Class ConfigurationUtility
 */
class ConfigurationUtility
{
    /**
     * Get extension settings
     */
    public static function getExtensionConfiguration(): array
    {
        if (version_compare(TYPO3_version, '9.0', '<')) {
            $settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['pxa_resultify_belogin_news'] ?: '');
        } else {
            $settings = GeneralUtility::makeInstance(ExtensionConfiguration::class)
                ->get('pxa_resultify_belogin_news');
        }

        if (!is_array($settings)) {
            $settings = [];
        }

        return $settings;
    }
}
