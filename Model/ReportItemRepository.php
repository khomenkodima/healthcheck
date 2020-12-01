<?php
namespace Khomenko\HealthCheck\Model;

use Khomenko\HealthCheck\Api\Data;
use Khomenko\HealthCheck\Model\ResourceModel\ReportItem as ResourceReportItem;
use Khomenko\HealthCheck\Model\ReportItemFactory;
use Khomenko\HealthCheck\Model\ResourceModel\ReportItem\CollectionFactory as ReportItemCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SortOrderBuilder;

/**
 * Search status CRUD class
 */
class ReportItemRepository implements \Khomenko\HealthCheck\Api\ReportItemRepositoryInterface
{
    /**
     * @var ResourceReportItem
     */
    protected $resource;
    /**
     * @var  ReportItemFactory
     */
    protected $reportItemFactory;
    /**
     * @var ReportItemCollectionFactory
     */
    protected $reportItemCollectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var Data\ReportItemSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;


    /**
     * @param ReportItemFactory $reportItemFactory;
     * @param ResourceReportItem $resource
     * @param ReportItemCollectionFactory $reportItemCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param Data\ReportItemSearchResultsInterfaceFactory $searchResultsFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        ReportItemFactory $reportItemFactory,
        ResourceReportItem $resource,
        ReportItemCollectionFactory $reportItemCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        Data\ReportItemSearchResultsInterfaceFactory $searchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    )
    {
        $this->resource = $resource;
        $this->reportItemFactory = $reportItemFactory;
        $this->reportItemCollectionFactory = $reportItemCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @param \Khomenko\HealthCheck\Api\Data\ReportItemInterface $reportItem
     * @throws InputException
     * @return \Khomenko\HealthCheck\Api\Data\ReportItemInterface
     */
    public function save(\Khomenko\HealthCheck\Api\Data\ReportItemInterface $reportItem) {
        try {
            $this->resource->save($reportItem);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the search status: %1', $exception->getMessage()),
                $exception
            );
        }
        return $reportItem;
    }


    /**
     * @param int $id
     * @return \Khomenko\HealthCheck\Api\Data\ReportItemInterface
     * @throws NoSuchEntityException
     */
    public function getById($id) {
        $reportItem = $this->reportItemFactory->create();
        $reportItem->load($id);
        if (!$reportItem->getId()) {
            throw new NoSuchEntityException(__('The search status item with the "%1" ID doesn\'t exist.', $id));
        }
        return $reportItem;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Khomenko\HealthCheck\Api\Data\ReportItemSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null){
        $collection = $this->reportItemCollectionFactory->create();
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
     * @param \Khomenko\HealthCheck\Api\Data\ReportItemInterface $reportItem
     * @return bool true on success
     * @throws CouldNotDeleteException
     */
    public function delete(\Khomenko\HealthCheck\Api\Data\ReportItemInterface $reportItem) {
        try {
            $this->resource->delete($reportItem);
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

    /**
     * @param string $filePath
     * @return bool
     */
    public function itemExists($filePath) {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('file_path', $filePath)
            ->create();

        $result = $this->getList($searchCriteria);
        if ($result->getTotalCount() == 0) {
            return false;
        }
        return true;
    }

    /**
     * @return bool|Data\ReportItemInterface
     */
    public function getLatestItem() {
        $sortOrder = $this->sortOrderBuilder
            ->setField('event_time')
            ->setDirection('DESC')
            ->create();
        $searchCriteria = $this->searchCriteriaBuilder
            ->addSortOrder($sortOrder)
            ->create();

        $result = $this->getList($searchCriteria);
        if ($result->getTotalCount() == 0) {
            return false;
        }
        $list = $result->getItems();
        return array_values($list)[0];
    }

    /**
     * @param $patternId
     * @return Data\ReportItemSearchResultsInterface
     */
    public function getItemsByPatterId($patternId)
    {
        $sortOrder = $this->sortOrderBuilder
            ->setField('event_time')
            ->setDirection('DESC')
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('pattern_id', $patternId)
            ->addSortOrder($sortOrder)
            ->create();

        return $this->getList($searchCriteria);
    }
}
