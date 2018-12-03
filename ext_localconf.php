<?php
defined('TYPO3_MODE') || die('Access denied.');

// Register task
// @codingStandardsIgnoreStart
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Pixelant\PxaResultifyBeloginNews\Task\ImportNewsTask::class] = [
    'extension' => $_EXTKEY,
    'title' => 'LLL:EXT:pxa_resultify_belogin_news/Resources/Private/Language/locallang_be.xlf:scheduler.task.name',
    'description' => 'LLL:EXT:pxa_resultify_belogin_news/Resources/Private/Language/locallang_be.xlf:scheduler.task.description'
];

// Extend Backend login class
// @NOTE there is no any hook to manipulate BE login template
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Backend\Controller\LoginController::class] = [
    'className' => \Pixelant\PxaResultifyBeloginNews\Controller\LoginController::class
];
// @codingStandardsIgnoreEnd
