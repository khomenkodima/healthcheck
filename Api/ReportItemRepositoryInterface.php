<?php
namespace Khomenko\HealthCheck\Api;

/**
 * Report item CRUD interface
 * @api
 */
interface ReportItemRepositoryInterface
{
    /**
     * Save report item
     *
     * @param \Khomenko\HealthCheck\Api\Data\ReportItemInterface $ReportItem
     * @return \Khomenko\HealthCheck\Api\Data\ReportItemInterface
     * @throws \Magento\Framework\Exception\InputException
     */
    public function save(\Khomenko\HealthCheck\Api\Data\ReportItemInterface $ReportItem);
    /**
     * Get report item by item ID.
     *
     * @param int $id
     * @return \Khomenko\HealthCheck\Api\Data\ReportItemInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);
    /**
     * Retrieve report items.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteriaInterface|null
     * @return \Khomenko\HealthCheck\Api\Data\ReportItemInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteriaInterface = null);
    /**
     * Delete report item item.
     *
     * @param \Khomenko\HealthCheck\Api\Data\ReportItemInterface $ReportItem
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Khomenko\HealthCheck\Api\Data\ReportItemInterface $ReportItem);
    /**
     * Delete report item item by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($id);
}
