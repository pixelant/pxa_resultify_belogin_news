<?php
namespace Pixelant\PxaResultifyBeloginNews\Task;

use Pixelant\PxaResultifyBeloginNews\Service\Task\ImportTaskService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Class ImportNewsTask
 * @package Pixelant\PxaResultifyBeloginNews\Task
 */
class ImportNewsTask extends AbstractTask
{
    /**
     * Execute import task
     *
     * @return bool
     */
    public function execute()
    {
        GeneralUtility::makeInstance(ImportTaskService::class)->import();

        return true;
    }
}
