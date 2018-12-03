<?php
declare(strict_types=1);
namespace Pixelant\PxaResultifyBeloginNews\Domain\Model;

use \TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class SysNews
 * @package Pixelant\PxaResultifyBeloginNews\Domain\Model
 */
class SysNews extends AbstractEntity
{
    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $content = '';

    /**
     * @var \DateTime
     */
    protected $pubDate = null;

    /**
     * @var string
     */
    protected $link = '';

    /**
     * @var int
     */
    protected $language = 0;

    /**
     * @var string
     */
    protected $externalUid = '';

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return \DateTime
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * @param \DateTime $pubDate
     */
    public function setPubDate(\DateTime $pubDate)
    {
        $this->pubDate = $pubDate;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link)
    {
        $this->link = $link;
    }

    /**
     * @return int
     */
    public function getLanguage(): int
    {
        return $this->language;
    }

    /**
     * @param int $language
     */
    public function setLanguage(int $language)
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getExternalUid(): string
    {
        return $this->externalUid;
    }

    /**
     * @param string $externalUid
     */
    public function setExternalUid(string $externalUid)
    {
        $this->externalUid = $externalUid;
    }
}
