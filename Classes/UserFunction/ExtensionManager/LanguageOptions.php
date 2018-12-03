<?php
declare(strict_types=1);

namespace Pixelant\PxaResultifyBeloginNews\UserFunction\ExtensionManager;

use Pixelant\PxaResultifyBeloginNews\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class LanguageOptions
 * @package Pixelant\PxaResultifyBeloginNews\UserFunction\ExtensionManager
 */
class LanguageOptions
{
    /**
     * Generate selector based on language uids
     *
     * @param array $args
     * @return string
     */
    public function languageSelector(array $args)
    {
        $output = "<div class='form-group'><select class='form-control' name='{$args['fieldName']}'>";
        $settings = ConfigurationUtility::getExtensionConfiguration();
        $languages = $settings['feed']['languages'] ?? '';

        foreach (GeneralUtility::intExplode(',', $languages, true) as $language) {
            $selected = $args['fieldValue'] === $language ? 'selected="selected"' : '';
            $label = $this->translate('language.' . $language) ?: ('Language UID - ' . $language);

            $output .= sprintf(
                '<option %s value="%d">%s</option>',
                $selected,
                $language,
                $label
            );
        }

        $output .= '</select></div>';

        return $output;
    }

    /**
     * Translate label
     *
     * @param $key
     * @return string
     */
    protected function translate($key): string
    {
        $lang = $GLOBALS['LANG'];

        return $lang->sL('LLL:EXT:pxa_resultify_belogin_news/Resources/Private/Language/locallang_be.xlf:' . $key) ?? '';
    }
}
