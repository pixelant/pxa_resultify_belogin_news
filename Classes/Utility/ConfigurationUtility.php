<?php

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

use Pixelant\PxaProductManager\Configuration\ConfigurationManager;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\Exception\MissingArrayPathException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use \TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

/**
 * Class ConfigurationUtility
 */
class ConfigurationUtility
{
    /**
     * Settings
     *
     * @var array
     */
    protected static $settings;

    /**
     */
    public static function getSettings($currentPageId = null)
    {
        if (self::$settings === null) {
            $configurationManager = GeneralUtility::makeInstance(ObjectManager::class)
                ->get(ConfigurationManagerInterface::class);

            $fullTyposcript = $configurationManager->getConfiguration(
                ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS
            );
            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($fullTyposcript, 'Debug', 16);
        }

        return self::$settings;
    }

}
