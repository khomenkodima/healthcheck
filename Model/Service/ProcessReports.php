<?php

namespace Khomenko\HealthCheck\Model\Service;

use Magento\Framework\Filesystem\DirectoryList;
use Khomenko\HealthCheck\Model\ReportPatternRepository;
use Khomenko\HealthCheck\Model\ReportPatternFactory;
use Khomenko\HealthCheck\Model\ReportItemRepository;
use Khomenko\HealthCheck\Model\ReportItemFactory;
use Khomenko\HealthCheck\Helper\Reports as ReportsHelper;
use Magento\Framework\App\ResourceConnection;


class ProcessReports
{
    /**
     * DirectoryList
     */
    protected $dir;
    /**
     * ReportPatternRepository
     */
    protected $reportPatternRepository;
    /**
     * ReportPatternFactory
     */
    protected $reportPatternFactory;
    /**
     * ReportItemRepository
     */
    protected $reportItemRepository;
    /**
     * ReportItemFactory
     */
    protected $reportItemFactory;
    /**
     * ReportsHelper
     */
    protected $helper;
    /**
     * ResourceConnection
     */
    protected $resource;


    public function __construct(
        DirectoryList $dir,
        ReportPatternRepository $reportPatternRepository,
        ReportPatternFactory $reportPatternFactory,
        ReportItemRepository $reportItemRepository,
        ReportItemFactory $reportItemFactory,
        ReportsHelper $helper,
        ResourceConnection $resource
    ) {
        $this->dir = $dir;
        $this->reportPatternRepository = $reportPatternRepository;
        $this->reportPatternFactory = $reportPatternFactory;
        $this->reportItemRepository = $reportItemRepository;
        $this->reportItemFactory = $reportItemFactory;
        $this->helper = $helper;
        $this->resource = $resource;
    }

    public function groupReports($timeLimit, $bunchAmount = null)
    {
        $files = $this->getReportFiles($timeLimit, $bunchAmount);
        $similarityPercentLimit = $this->helper->getSimilarityPercentLimit();
        $processedFiles = 0;
        $latestItem = $this->reportItemRepository->getLatestItem();
        foreach ($files as $file) {
            if ($latestItem && $latestItem->getEventTime() > filemtime($file)) {
                continue;
            }
            if ($this->reportItemRepository->itemExists($file)) {
                continue;
            }
            $c1 = file_get_contents($file);
            $p = 0;
            foreach ($this->getPatterns() as $pattern) {
                $patternContent = $pattern->getContent();
                similar_text($c1, $patternContent, $p);
                if ($p >= $similarityPercentLimit) {
                    $reportItem = $this->reportItemFactory->create();
                    $reportItem->setPatternId($pattern->getId());
                    $reportItem->setFilePath($file);
                    $reportItem->setEventTime(filemtime($file));
                    $this->reportItemRepository->save($reportItem);
                    $processedFiles ++;
                    break;
                }
            }
            if ($p < $similarityPercentLimit) {
                $path = str_replace(BP . '/', '', $file);
                $reportPattern = $this->reportPatternFactory->create();
                $reportPattern->setFilePath($path);
                $reportPattern->setContent($c1);
                $reportPattern->setShortContent(substr($c1, 0, 100));
                $reportPattern->setCntTotal(1);
                $reportPattern->setCnt24h(1);
                $reportPattern->setCnt1h(1);
                $this->reportPatternRepository->save($reportPattern);

                $reportItem = $this->reportItemFactory->create();
                $reportItem->setPatternId($reportPattern->getId());
                $reportItem->setFilePath($path);
                $reportItem->setEventTime(filemtime($file));
                $this->reportItemRepository->save($reportItem);

                $processedFiles++;
            }
            if ($bunchAmount && $processedFiles > $bunchAmount) {
                break;
            }
        }
        $this->updateCounts();
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    private function getReportFiles($timeLimit)
    {
        $dirPath =  $this->dir->getPath('var') . '/report/';
        $files = [];
        $timeLimit = time() -  (60 * 60 * 24 * $timeLimit);
        foreach (scandir($dirPath) as $file) {
            $file = $dirPath . $file;
            if (!is_file($file)) {
                continue;
            }
            if (filemtime($file) < $timeLimit) {
                continue;
            }
            $files[] = $file;
        }
        usort($files, function($a, $b) {
            return filemtime($a) > filemtime($b);
        });
        return $files;
    }

    /**
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternInterface[]
     */
    public function getPatterns()
    {
        $list = $this->reportPatternRepository->getList();
        return $list->getItems();
    }

    /**
     *
     */
    private function updateCounts()
    {
        $connection = $this->resource->getConnection();
        $sql = "select pattern_id, count(*) as cnt from healthcheck_report_item group by pattern_id";
        $result = $connection->fetchAll($sql);
        $patterns = [];
        foreach ($result as $item) {
            $patterns[$item['pattern_id']] = ['total' => $item['cnt'], '1h' => 0, '24h' => 0];
        }
        $sql = "select pattern_id, count(*) as cnt from healthcheck_report_item where event_time >=  NOW() - INTERVAL 24 HOUR group by pattern_id";
        $result = $connection->fetchAll($sql);
        foreach ($result as $item) {
            $patterns[$item['pattern_id']]['24h'] = $item['cnt'];
        }
        $sql = "select pattern_id, count(*) as cnt from healthcheck_report_item where event_time >=  NOW() - INTERVAL 1 HOUR group by pattern_id";
        $result = $connection->fetchAll($sql);
        foreach ($result as $item) {
            $patterns[$item['pattern_id']]['1h'] = $item['cnt'];
        }

        foreach ($this->reportPatternRepository->getList()->getItems() as $pattern) {
            $_pattern = $patterns[$pattern->getId()];
            if ($_pattern['total'] != $pattern->getCntTotal() ||
                $_pattern['24h'] != $pattern->getCnt24h() ||
                $_pattern['1h'] != $pattern->getCnt1h()
            ) {
                $pattern->setCntTotal($_pattern['total']);
                $pattern->setCnt24h($_pattern['24h']);
                $pattern->setCnt1h($_pattern['1h']);
            }
            $this->reportPatternRepository->save($pattern);
        }
    }

}
