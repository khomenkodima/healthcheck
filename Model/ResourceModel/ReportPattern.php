<?php

namespace Khomenko\HealthCheck\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ReportPattern extends AbstractDb
{
    /**
     * Resource initialization
     *
     * @return void
     *
     */
    protected function _construct()
    {
        $this->_init('healthcheck_report_pattern', 'entity_id');
    }
}
