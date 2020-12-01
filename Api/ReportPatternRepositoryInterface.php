<?php
namespace Khomenko\HealthCheck\Api;

/**
 * Report pattern CRUD interface
 * @api
 */
interface ReportPatternRepositoryInterface
{
    /**
     * Save report pattern
     *
     * @param \Khomenko\HealthCheck\Api\Data\ReportPatternInterface $reportPattern
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternInterface
     * @throws \Magento\Framework\Exception\InputException
     */
    public function save(\Khomenko\HealthCheck\Api\Data\ReportPatternInterface $reportPattern);
    /**
     * Get report pattern by item ID.
     *
     * @param int $id
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);
    /**
     * Retrieve report patterns.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteriaInterface|null
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteriaInterface = null);
    /**
     * Delete report pattern item.
     *
     * @param \Khomenko\HealthCheck\Api\Data\ReportPatternInterface $reportPattern
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Khomenko\HealthCheck\Api\Data\ReportPatternInterface $reportPattern);
    /**
     * Delete report pattern item by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($id);
}
