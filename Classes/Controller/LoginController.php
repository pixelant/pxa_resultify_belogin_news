<?php
declare(strict_types=1);

namespace Pixelant\PxaResultifyBeloginNews\Controller;

use Pixelant\PxaResultifyBeloginNews\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class LoginController
 *
 * Extend original class to manipulate with view and system news items
 * There is any hook to do this in any other way
 */
class LoginController extends \TYPO3\CMS\Backend\Controller\LoginController
{
    /**
     * Typoscript settings
     *
     * @var array
     */
    protected $settings = [];

    /**
     * Show news for selected language
     *
     * @var int
     */
    protected $activeLanguage = 0;

    /**
     * Initialize
     *
     * Generate settings and active language
     */
    public function __construct()
    {
        $this->settings = $this->getSettings();

        // Get language
        $configuration = ConfigurationUtility::getExtensionConfiguration();
        $this->activeLanguage = intval($configuration['feed']['language'] ?? 0);

        parent::__construct();
    }

    /**
     * Get system news with additional fields and filter it with language
     *
     * @return array
     */
    protected function getSystemNews(): array
    {
        $systemNewsTable = 'sys_news';
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($systemNewsTable);
        $expr = $queryBuilder->expr();
        $systemNews = [];
        $systemNewsRecords = $queryBuilder
            ->select('title', 'content', 'crdate', 'tx_pxaresultifybeloginnews_pub_date', 'tx_pxaresultifybeloginnews_link')
            ->from($systemNewsTable)
            ->where(
                $expr->orX(
                    // Get resultify news by language
                    // Not empty external uid means it's from resultify site
                    $expr->andX(
                        $expr->eq(
                            'tx_pxaresultifybeloginnews_language',
                            $queryBuilder->createNamedParameter($this->activeLanguage, \PDO::PARAM_INT)
                        ),
                        $expr->neq(
                            'tx_pxaresultifybeloginnews_external_uid',
                            $queryBuilder->createNamedParameter('', \PDO::PARAM_STR)
                        )
                    ),
                    // Or get system news with language 0, which might be added in TYPO3 manually
                    $expr->andX(
                        $expr->eq(
                            'tx_pxaresultifybeloginnews_language',
                            $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)
                        ),
                        $expr->eq(
                            'tx_pxaresultifybeloginnews_external_uid',
                            $queryBuilder->createNamedParameter('', \PDO::PARAM_STR)
                        )
                    )
                )
            )
            ->orderBy('crdate', 'DESC')
            ->execute()
            ->fetchAll();

        if (isset($this->settings['languages'][$this->activeLanguage]['dateFormat'])
            && !empty($this->settings['languages'][$this->activeLanguage]['dateFormat'])
        ) {
            $format = $this->settings['languages'][$this->activeLanguage]['dateFormat'];
        } else {
            $format = $GLOBALS['TYPO3_CONF_VARS']['SYS']['ddmmyy'];
        }

        foreach ($systemNewsRecords as $systemNewsRecord) {
            $date = intval($systemNewsRecord['tx_pxaresultifybeloginnews_pub_date'] ?: $systemNewsRecord['crdate']);
            $systemNews[] = [
                'date' => strpos($format, '%') !== false ? strftime($format, $date) : date($format, $date),
                'header' => $systemNewsRecord['title'],
                'content' => $systemNewsRecord['content'],
                'link' => $systemNewsRecord['tx_pxaresultifybeloginnews_link']
            ];
        }
        return $systemNews;
    }

    /**
     * Add our own partials path
     *
     * @return \TYPO3\CMS\Fluid\View\StandaloneView
     */
    protected function getFluidTemplateObject()
    {
        $view = parent::getFluidTemplateObject();

        $partialsPath = $view->getPartialRootPaths();
        // Add new partials path
        array_push(
            $partialsPath,
            GeneralUtility::getFileAbsFileName('EXT:pxa_resultify_belogin_news/Resources/Private/Partials')
        );
        $view->setPartialRootPaths($partialsPath);

        // Add settings
        $view->assign('pxaSettings', $this->settings);
        // Add active language
        $view->assign('activeLanguage', $this->activeLanguage);

        return $view;
    }

    /**
     * Get custom settings of "pxa_resultify_belogin_news"
     *
     * @return array
     */
    private function getSettings(): array
    {
        $configurationManager = GeneralUtility::makeInstance(ObjectManager::class)->get(ConfigurationManagerInterface::class);
        $settings = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'pxaresultifybeloginnews'
        );

        return is_array($settings) ? $settings : [];
    }
}
