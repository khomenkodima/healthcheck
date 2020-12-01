<?php

namespace Khomenko\HealthCheck\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Khomenko\HealthCheck\Api\Data\ReportPatternInterface;

class ReportPattern extends AbstractModel implements IdentityInterface, ReportPatternInterface
{

    /**
     * Cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'report_pattern';
    /**
     * Cache tag
     *
     * @var string
     */
    protected $_cacheTag = 'report_pattern';
    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'report_pattern';


    protected function _construct()
    {
        $this->_init(\Khomenko\HealthCheck\Model\ResourceModel\ReportPattern::class);
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
    public function getShortContent()
    {
        return $this->_getData('short_content');
    }
    /**
     * @inheritDoc
     */
    public function setShortContent($value)
    {
        return $this->setData('short_content', $value);
    }
    /**
     * @inheritDoc
     */
    public function getCnt1h()
    {
        return $this->_getData('cnt1h');
    }
    /**
     * @inheritDoc
     */
    public function setCnt1h($value)
    {
        return $this->setData('cnt1h', $value);
    }
    /**
     * @inheritDoc
     */
    public function getCnt24h()
    {
        return $this->_getData('cnt24h');
    }
    /**
     * @inheritDoc
     */
    public function setCnt24h($value)
    {
        return $this->setData('cnt24h', $value);
    }
    /**
     * @inheritDoc
     */
    public function getCntTotal()
    {
        return $this->_getData('total_cnt');
    }
    /**
     * @inheritDoc
     */
    public function setCntTotal($value)
    {
        return $this->setData('total_cnt', $value);
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
