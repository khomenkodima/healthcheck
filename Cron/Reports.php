<?php
namespace Khomenko\HealthCheck\Cron;

use Khomenko\HealthCheck\Model\Service\ProcessReports;
use Khomenko\HealthCheck\Helper\Reports as ReportsHelper;

/**
 * Performs scheduled backup.
 */
class Reports
{
    /**
     * ProcessReports
     */
    protected $processReports;
    /**
     * ReportsHelper
     */
    protected $helper;

    public function __construct(
        ProcessReports $processReports,
        ReportsHelper $helper
    ) {
        $this->helper = $helper;
        $this->processReports = $processReports;
    }

    /**
     * Create Backup
     *
     * @return $this
     * @throws \Exception
     */
    public function execute()
    {
        $this->processReports->groupReports($this->helper->getInitPeriod(), $this->helper->getCronBunchAmount());
        return $this;
    }
}
