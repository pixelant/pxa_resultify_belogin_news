<?php
defined('TYPO3_MODE') || die('Access denied.');

// Register task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Pixelant\PxaResultifyBeloginNews\Task\ImportNewsTask::class] = [
    'extension' => $_EXTKEY,
    'title' => 'LLL:EXT:pxa_resultify_belogin_news/Resources/Private/Language/locallang_be.xlf:scheduler.task.name',
    'description' => 'LLL:EXT:pxa_resultify_belogin_news/Resources/Private/Language/locallang_be.xlf:scheduler.task.name.description',
    'additionalFields' => \Pixelant\PxaResultifyBeloginNews\Task\ImportNewsTaskAdditionalFieldProvider::class
];