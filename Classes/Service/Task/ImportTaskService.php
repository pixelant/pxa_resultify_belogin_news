<?php
declare(strict_types=1);

namespace Pixelant\PxaResultifyBeloginNews\Service\Task;

use Pixelant\PxaResultifyBeloginNews\Domain\Model\SysNews;
use Pixelant\PxaResultifyBeloginNews\Domain\Repository\SysNewsRepository;
use Pixelant\PxaResultifyBeloginNews\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

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
     * @var SysNewsRepository
     */
    protected $sysNewsRepository = null;

    /**
     * Mapping from feed to model
     * This array include only simple string fields
     *
     * @var array
     */
    protected $importFieldsToProperty = [
        'title' => 'title',
        'link' => 'link',
        'description' => 'content'
    ];

    /**
     * Initialize
     */
    public function __construct()
    {
        $settings = ConfigurationUtility::getExtensionConfiguration();

        $this->languages = GeneralUtility::intExplode(',', $settings['feed']['languages'], true);
        $this->url = $settings['feed']['fetchUrl'];
    }

    /**
     * @param SysNewsRepository $sysNewsRepository
     */
    public function injectSysNewsRepository(SysNewsRepository $sysNewsRepository)
    {
        $this->sysNewsRepository = $sysNewsRepository;
    }

    /**
     * Import resultify news to system news
     */
    public function import()
    {
        foreach ($this->languages as $language) {
            $items = $this->getFeedItemsArray(
                $this->getFeedUrlForLanguage($language)
            );

            foreach ($items as $item) {
                $pubDate = new \DateTime($item['pubDate']);

                $sysNews = $this->sysNewsRepository->findByExternalUidAndLanguage($item['guid'], $language);

                if ($sysNews === null) {
                    $sysNews = GeneralUtility::makeInstance(SysNews::class);
                    $sysNews->setExternalUid($item['guid']);
                    $sysNews->setPid(0);
                    $sysNews->setLanguage($language);
                }

                // If pub date was not set yet and differs - update
                if ($sysNews->getCrdate() === null
                    || $sysNews->getCrdate()->getTimestamp() !== $pubDate->getTimestamp()
                ) {
                    $sysNews->setCrdate($pubDate);
                }

                // Set simple fields
                foreach ($this->importFieldsToProperty as $importField => $property) {
                    $currentValue = ObjectAccess::getProperty($sysNews, $property);
                    $newValue = $item[$importField];

                    if ($newValue != $currentValue) {
                        ObjectAccess::setProperty($sysNews, $property, $newValue);
                    }
                }

                if ($sysNews->getUid() === null) {
                    $this->sysNewsRepository->add($sysNews);
                } elseif ($sysNews->_isDirty()) {
                    $this->sysNewsRepository->update($sysNews);
                }
            }
        }

        // Persist results
        GeneralUtility::makeInstance(ObjectManager::class)->get(PersistenceManager::class)->persistAll();
    }

    /**
     * Fetch XML data from url and convert to array
     *
     * @param $url
     * @return array
     */
    protected function getFeedItemsArray(string $url): array
    {
        $response = GeneralUtility::getUrl($url);
        if (is_string($response) && !empty($response)) {
            $parseXml = simplexml_load_string($response);

            if ($parseXml !== false) {
                $items = [];

                foreach ($parseXml->channel->item as $xmlItem) {
                    $item = [];
                    foreach ($xmlItem as $key => $value) {
                        $item[(string)$key] = (string)$value;
                    }
                    $items[] = $item;
                }

                return $items;
            }
        }

        return [];
    }

    /**
     * Get feed url with language parameter
     *
     * @param $language
     * @return string
     */
    protected function getFeedUrlForLanguage(int $language): string
    {
        if (strpos($this->url, '?') === false) {
            return $this->url . '?L=' . $language;
        } else {
            return $this->url . '&L=' . $language;
        }
    }
}
