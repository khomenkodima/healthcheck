<?php
namespace Khomenko\HealthCheck\Api\Data;

/**
 * @api
 */
interface ReportPatternSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get Report patterns list.
     *
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternInterface[]
     */
    public function getItems();

    /**
     * Set Report patterns list.
     *
     * @api
     * @param \Khomenko\HealthCheck\Api\Data\ReportPatternInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
