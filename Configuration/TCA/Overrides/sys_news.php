<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {
    $ll = 'LLL:EXT:pxa_resultify_belogin_news/Resources/Private/Language/locallang_db.xlf:';

    $columns = [
        'tx_pxaresultifybeloginnews_pub_date' => [
            'exclude' => true,
            'label' => $ll . 'sys_news.pub_date',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 16,
                'eval' => 'datetime,int',
                'default' => 0
            ]
        ],
        'tx_pxaresultifybeloginnews_link' => [
            'exclude' => true,
            'label' => $ll . 'sys_news.link',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'size' => 30,
                'eval' => 'trim',
            ]
        ],
        'tx_pxaresultifybeloginnews_language' => [
            'exclude' => true,
            'label' => $ll . 'sys_news.language',
            'config' => [
                'type' => 'input',
                'readOnly' => true
            ]
        ],
        'tx_pxaresultifybeloginnews_external_uid' => [
            'exclude' => true,
            'label' => $ll . 'sys_news.external_uid',
            'config' => [
                'type' => 'input',
                'readOnly' => true
            ]
        ]
    ];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_news', $columns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'sys_news',
        '--div--;' . $ll . 'sys_news.tab.resultify,' . implode(', ', array_keys($columns))
    );
});
