<?php
namespace Khomenko\HealthCheck\Block\Adminhtml;

use Magento\Framework\View\Element\AbstractBlock;
use Khomenko\HealthCheck\Model\ReportPatternRepository;
use Khomenko\HealthCheck\Model\ReportItemRepository;
use Khomenko\HealthCheck\Helper\Reports as ReportsHelper;

class Reports extends \Magento\Backend\Block\Template
{
    /**
     * ReportPatternRepository
     */
    protected $reportPatternRepository;
    /**
     * ReportItemRepository
     */
    protected $reportItemRepository;
    /**
     * ReportsHelper
     */
    protected $helper;

    /**
     * Reports constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param ReportsHelper $helper
     * @param ReportItemRepository $reportItemRepository
     * @param ReportPatternRepository $reportPatternRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        ReportsHelper $helper,
        ReportItemRepository $reportItemRepository,
        ReportPatternRepository $reportPatternRepository,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->reportItemRepository = $reportItemRepository;
        $this->reportPatternRepository = $reportPatternRepository;
        parent::__construct($context, $data);
    }

    public function getReports()
    {
        $reports = [];
        $patterns =  $this->reportPatternRepository->getList()->getItems();
        foreach ($patterns as $pattern) {
            $items = $this->reportItemRepository->getItemsByPatterId($pattern->getId());
            $info = [];
            $info['title'] = basename($pattern->getFilePath());
            $info['short'] = substr($pattern->getContent(), 0, 100);
            $info['count'] = $items->getTotalCount();
            $info['latest'] = array_values($items->getItems())[0]->getEventTime();
            $info['last_1'] = 0;
            $info['last_24'] = 0;
            foreach ($items->getItems() as $_item) {
                if (strtotime($_item->getEventTime()) > strtotime("-1 hour")) {
                    $info['last_1']++;
                }
                if (strtotime($_item->getEventTime()) > strtotime("-24 hours")) {
                    $info['last_24']++;
                }
            }
            $reports[] = ['pattern_info' => $info, 'pattern' => $pattern, 'items' => $items];
        }
        usort($reports, function($a, $b) {
            return $a['pattern_info']['latest'] < $b['pattern_info']['latest'];
        });
        return $reports;
    }
}
