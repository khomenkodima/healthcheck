<?php

namespace Khomenko\HealthCheck\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Khomenko\HealthCheck\Api\Data\ReportItemInterface;

class ReportItem
    extends AbstractModel implements IdentityInterface, ReportItemInterface
{

    /**
     * Cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'report_item';
    /**
     * Cache tag
     *
     * @var string
     */
    protected $_cacheTag = 'report_item';
    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'report_item';


    protected function _construct()
    {
        $this->_init(\Khomenko\HealthCheck\Model\ResourceModel\ReportItem::class);
    }
    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->_getData('entity_id');
    }
    /**
     * @inheritDoc
     */
    public function setId($value)
    {
        return $this->setData('entity_id', $value);
    }
    /**
     * @inheritDoc
     */
    public function getPatternId()
    {
        return $this->_getData('pattern_id');
    }
    /**
     * @inheritDoc
     */
    public function setPatternId($value)
    {
        return $this->setData('pattern_id', $value);
    }
    /**
     * @inheritDoc
     */
    public function getFilePath()
    {
        return $this->_getData('file_path');
    }
    /**
     * @inheritDoc
     */
    public function setFilePath($value)
    {
        return $this->setData('file_path', $value);
    }
    /**
     * @inheritDoc
     */
    public function getContent()
    {
        return $this->_getData('content');
    }
    /**
     * @inheritDoc
     */
    public function setContent($value)
    {
        return $this->setData('content', $value);
    }
    /**
     * @inheritDoc
     */
    public function getEventTime()
    {
        return $this->_getData('event_time');
    }
    /**
     * @inheritDoc
     */
    public function setEventTime($value)
    {
        return $this->setData('event_time', $value);
    }
    /**
     * Return unique ID(s) for each object in system
     * @return string[]
     * @api
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
