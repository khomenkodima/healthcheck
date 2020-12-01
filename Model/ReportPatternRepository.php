<?php
namespace Khomenko\HealthCheck\Model;

use Khomenko\HealthCheck\Api\Data;
use Khomenko\HealthCheck\Model\ResourceModel\ReportPattern as ResourceReportPattern;
use Khomenko\HealthCheck\Model\ReportPatternFactory;
use Khomenko\HealthCheck\Model\ResourceModel\ReportPattern\CollectionFactory as ReportPatternCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Search status CRUD class
 */
class ReportPatternRepository implements \Khomenko\HealthCheck\Api\ReportPatternRepositoryInterface
{
    /**
     * @var ResourceReportPattern
     */
    protected $resource;
    /**
     * @var  ReportPatternFactory
     */
    protected $reportPatternFactory;
    /**
     * @var ReportPatternCollectionFactory
     */
    protected $reportPatternCollectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var Data\ReportPatternSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param ReportPatternFactory $reportPatternFactory;
     * @param ResourceReportPattern $resource
     * @param ReportPatternCollectionFactory $reportPatternCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param Data\ReportPatternSearchResultsInterfaceFactory $searchResultsFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        ReportPatternFactory $reportPatternFactory,
        ResourceReportPattern $resource,
        ReportPatternCollectionFactory $reportPatternCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        Data\ReportPatternSearchResultsInterfaceFactory $searchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->resource = $resource;
        $this->reportPatternFactory = $reportPatternFactory;
        $this->reportPatternCollectionFactory = $reportPatternCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param \Khomenko\HealthCheck\Api\Data\ReportPatternInterface $reportPattern
     * @throws InputException
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternInterface
     */
    public function save(\Khomenko\HealthCheck\Api\Data\ReportPatternInterface $reportPattern) {
        try {
            $this->resource->save($reportPattern);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the search status: %1', $exception->getMessage()),
                $exception
            );
        }
        return $reportPattern;
    }


    /**
     * @param int $id
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternInterface
     * @throws NoSuchEntityException
     */
    public function getById($id) {
        $reportPattern = $this->reportPatternFactory->create();
        $reportPattern->load($id);
        if (!$reportPattern->getId()) {
            throw new NoSuchEntityException(__('The search status item with the "%1" ID doesn\'t exist.', $id));
        }
        return $reportPattern;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null){
        $collection = $this->reportPatternCollectionFactory->create();
        if ($searchCriteria) {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }
        $searchResults = $this->searchResultsFactory->create();
        if ($searchCriteria) {
            $searchResults->setSearchCriteria($searchCriteria);
        }
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param \Khomenko\HealthCheck\Api\Data\ReportPatternInterface $reportPattern
     * @return bool true on success
     * @throws CouldNotDeleteException
     */
    public function delete(\Khomenko\HealthCheck\Api\Data\ReportPatternInterface $reportPattern) {
        try {
            $this->resource->delete($reportPattern);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the search status item: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @param int $id
     * @return bool true on success
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($id) {
        return $this->delete($this->getById($id));
    }
}
