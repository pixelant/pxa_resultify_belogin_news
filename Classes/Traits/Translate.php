<?php

namespace Pixelant\PxaResultifyBeloginNews\Traits;

/**
 * Use if you need to translate in BE
 */
trait Translate
{
    /**
     * Path to the locallang file
     *
     * @var string
     */
    protected $LLPATH = 'LLL:EXT:pxa_resultify_belogin_news/Resources/Private/Language/locallang_be.xlf:';

    /**
     * Translate by key
     *
     * @param string $key
     * @param array $arguments
     * @return string
     */
    protected function translate($key, array $arguments = [])
    {
        if (TYPO3_MODE === 'BE') {
            $label = $this->getLanguageService()->sL($this->LLPATH . $key) ?: '';

            if (!empty($arguments)) {
                $label = vsprintf($label, $arguments);
            }
        }

        return isset($label) ? $label : '';
    }

    /**
     * Return language service instance
     *
     * @return \TYPO3\CMS\Lang\LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }
}
