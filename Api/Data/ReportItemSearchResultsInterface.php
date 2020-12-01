<?php
namespace Khomenko\HealthCheck\Api\Data;

/**
 * @api
 */
interface ReportItemSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get Report patterns list.
     *
     * @return \Khomenko\HealthCheck\Api\Data\ReportItemInterface[]
     */
    public function getItems();

    /**
     * Set Report patterns list.
     *
     * @api
     * @param \Khomenko\HealthCheck\Api\Data\ReportItemInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
