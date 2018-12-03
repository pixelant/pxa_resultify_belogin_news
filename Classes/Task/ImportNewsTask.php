<?php
declare(strict_types=1);

namespace Pixelant\PxaResultifyBeloginNews\Task;

use Pixelant\PxaResultifyBeloginNews\Service\Task\ImportTaskService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
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
        GeneralUtility::makeInstance(ObjectManager::class)->get(ImportTaskService::class)->import();

        return true;
    }
}
