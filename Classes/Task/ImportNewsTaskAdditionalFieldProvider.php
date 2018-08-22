<?php

namespace Pixelant\PxaResultifyBeloginNews\Task;

use Pixelant\PxaResultifyBeloginNews\Utility\ConfigurationUtility;
use TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface;
use TYPO3\CMS\Scheduler\Controller\SchedulerModuleController;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Class ImportNewsTaskAdditionalFieldProvider
 * @package Pixelant\PxaResultifyBeloginNews\Task
 */
class ImportNewsTaskAdditionalFieldProvider implements AdditionalFieldProviderInterface
{
    /**
     * Provide fields
     *
     * @param array $taskInfo
     * @param AbstractTask $task
     * @param SchedulerModuleController $schedulerModule
     * @return array
     */
    public function getAdditionalFields(array &$taskInfo, $task, SchedulerModuleController $schedulerModule)
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(ConfigurationUtility::getSettings(),'Debug',16);die;
        if ($schedulerModule->CMD === 'add') {
            $taskInfo['language'] = null;
            $taskInfo['documentsToIndexLimit'] = 50;
            $taskInfo['forcedWebRoot'] = '';
        }

        if ($schedulerModule->CMD === 'edit') {
            $taskInfo['site'] = $this->siteRepository->getSiteByRootPageId($task->getRootPageId());
            $taskInfo['documentsToIndexLimit'] = $task->getDocumentsToIndexLimit();
            $taskInfo['forcedWebRoot'] = $task->getForcedWebRoot();
        }

        $additionalFields['site'] = [
            'code' => $siteSelectorField->getAvailableSitesSelector('tx_scheduler[site]',
                $taskInfo['site']),
            'label' => 'LLL:EXT:solr/Resources/Private/Language/locallang.xlf:field_site',
            'cshKey' => '',
            'cshLabel' => ''
        ];

        $additionalFields['documentsToIndexLimit'] = [
            'code' => '<input type="number" class="form-control" name="tx_scheduler[documentsToIndexLimit]" value="' . htmlspecialchars($taskInfo['documentsToIndexLimit']) . '" />',
            'label' => 'LLL:EXT:solr/Resources/Private/Language/locallang.xlf:indexqueueworker_field_documentsToIndexLimit',
            'cshKey' => '',
            'cshLabel' => ''
        ];

        $additionalFields['forcedWebRoot'] = [
            'code' => '<input type="text" class="form-control" name="tx_scheduler[forcedWebRoot]" value="' . htmlspecialchars($taskInfo['forcedWebRoot']) . '" />',
            'label' => 'LLL:EXT:solr/Resources/Private/Language/locallang.xlf:indexqueueworker_field_forcedWebRoot',
            'cshKey' => '',
            'cshLabel' => ''
        ];

        return $additionalFields;
    }

    /**
     * Checks any additional data that is relevant to this task. If the task
     * class is not relevant, the method is expected to return TRUE
     *
     * @param array $submittedData reference to the array containing the data submitted by the user
     * @param SchedulerModuleController $schedulerModule reference to the calling object (Scheduler's BE module)
     * @return bool True if validation was ok (or selected class is not relevant), FALSE otherwise
     */
    public function validateAdditionalFields(
        array &$submittedData,
        SchedulerModuleController $schedulerModule
    ) {
        die('test');
        $result = false;

        // validate site
        $sites = $this->siteRepository->getAvailableSites();
        if (array_key_exists($submittedData['site'], $sites)) {
            $result = true;
        }

        // escape limit
        $submittedData['documentsToIndexLimit'] = intval($submittedData['documentsToIndexLimit']);

        return $result;
    }

    /**
     * Saves any additional input into the current task object if the task
     * class matches.
     *
     * @param array $submittedData array containing the data submitted by the user
     * @param AbstractTask $task reference to the current task object
     */
    public function saveAdditionalFields(
        array $submittedData,
        AbstractTask $task
    ) {
        if (!$this->isTaskInstanceofIndexQueueWorkerTask($task)) {
            return;
        }

        $task->setRootPageId($submittedData['site']);
        $task->setDocumentsToIndexLimit($submittedData['documentsToIndexLimit']);
        $task->setForcedWebRoot($submittedData['forcedWebRoot']);
    }
}
