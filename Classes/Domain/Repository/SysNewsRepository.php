<?php
declare(strict_types=1);

namespace Pixelant\PxaResultifyBeloginNews\Domain\Repository;

use Pixelant\PxaResultifyBeloginNews\Domain\Model\SysNews;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Class SysNewsRepository
 * @package Pixelant\PxaResultifyBeloginNews\Domain\Repository
 */
class SysNewsRepository extends Repository
{
    /**
     * Get sys news if already exist or return null
     *
     * @param string $externalUid
     * @param int $language
     * @return SysNews
     */
    public function findByExternalUidAndLanguage(string $externalUid, int $language)
    {
        $query = $this->createQuery();

        $query->matching(
            $query->logicalAnd([
                $query->equals('externalUid', $externalUid),
                $query->equals('language', $language)
            ])
        );

        return $query->execute()->getFirst();
    }
}
