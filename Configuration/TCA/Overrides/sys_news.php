<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {
    $ll = 'LLL:EXT:pxa_resultify_belogin_news/Resources/Private/Language/locallang_db.xlf:';

    $columns = [
        'tx_pxaresultifybeloginnews_language' => [
            'exclude' => false,
            'label' => $ll . 'sys_news.language',
            'config' => [
                'type' => 'none'
            ]
        ],
        'tx_pxaresultifybeloginnews_external_uid' => [
            'exclude' => false,
            'label' => $ll . 'sys_news.external_uid',
            'config' => [
                'type' => 'none'
            ]
        ]
    ];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_news', $columns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'sys_news',
        '--div--;' . $ll . 'sys_news.tab.resultify,
         tx_pxaresultifybeloginnews_language, tx_pxaresultifybeloginnews_external_uid'
    );
});
