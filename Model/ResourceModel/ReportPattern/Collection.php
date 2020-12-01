<?php

namespace Khomenko\HealthCheck\Model\ResourceModel\ReportPattern;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * ID Field Name
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'report_pattern_collection';
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Khomenko\HealthCheck\Model\ReportPattern::class, \Khomenko\HealthCheck\Model\ResourceModel\ReportPattern::class);
    }
}
