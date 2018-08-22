<?php

namespace Pixelant\PxaResultifyBeloginNews\Service\Task;

use Pixelant\PxaResultifyBeloginNews\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ImportTaskService
 * @package Pixelant\PxaResultifyBeloginNews\Service\Task
 */
class ImportTaskService
{
    /**
     * Import languages
     *
     * @var array
     */
    protected $languages = [];

    /**
     * Url where to fetch feed
     *
     * @var string
     */
    protected $url = '';

    /**
     * Initialize
     */
    public function __construct()
    {
        $settings = ConfigurationUtility::getSettings();

        $this->languages = GeneralUtility::intExplode(',', $settings['import']['languages']);
        $this->url = $settings['import']['fetchUrl'];
    }

    /**
     * Import resultify news to system news
     */
    public function import()
    {
        foreach ($this->languages as $language) {
            $feedData = $this->getFeedArray(
                $this->getFeedUrlForLanguage($language)
            );
        }
    }

    protected function getFeedArray($url)
    {
        $response = GeneralUtility::getUrl($url);
        $xml = json_decode(json_encode((array)simplexml_load_string($response)), true);
        return $xml;
    }

    /**
     * Get feed url with language parameter
     *
     * @param $language
     * @return string
     */
    protected function getFeedUrlForLanguage($language)
    {
        if (strpos($this->url, '?') === false) {
            return $this->url . '?L=' . $language;
        } else {
            return $this->url . '&L=' . $language;
        }
    }
}
