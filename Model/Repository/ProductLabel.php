<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\Repository;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;
use Smile\ProductLabel\Api\Data\ProductLabelInterfaceFactory;
use Smile\ProductLabel\Api\Data\ProductLabelSearchResultsInterfaceFactory;
use Smile\ProductLabel\Api\ProductLabelRepositoryInterface;
use Smile\ProductLabel\Model\Repository\Manager as RepositoryManager;
use Smile\ProductLabel\Model\Repository\ManagerFactory as RepositoryManagerFactory;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel as ProductLabelResourceModel;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory as ProductLabelCollectionFactory;

/**
 * ProductLabel Repository
 */
class ProductLabel implements ProductLabelRepositoryInterface
{
    protected RepositoryManager $productLabelRepositoryManager;

    public function __construct(
        RepositoryManagerFactory $repositoryManagerFactory,
        ProductLabelInterfaceFactory $objectFactory,
        ProductLabelResourceModel $objectResource,
        ProductLabelCollectionFactory $objectCollectionFactory,
        ProductLabelSearchResultsInterfaceFactory $objectSearchResultsFactory
    ) {
        $this->productLabelRepositoryManager = $repositoryManagerFactory->create(
            [
                'objectFactory' => $objectFactory,
                'objectResource' => $objectResource,
                'objectCollectionFactory' => $objectCollectionFactory,
                'objectSearchResultsFactory' => $objectSearchResultsFactory,
                'identifierFieldName' => ProductLabelInterface::PRODUCTLABEL_ID,
            ]
        );
    }

    /**
     * Retrieve a productLabel by its id
     *
     * @throws NoSuchEntityException
     */
    public function getById(int $objectId): ProductLabelInterface
    {
        /** @var ProductLabelInterface $productLabel */
        $productLabel = $this->productLabelRepositoryManager->getEntityById($objectId);
        return $productLabel;
    }

    /**
     * Retrieve a productLabel by its identifier.
     *
     * @throws NoSuchEntityException
     */
    public function getByIdentifier(string $objectIdentifier): ProductLabelInterface
    {
        /** @var ProductLabelInterface $productLabel */
        $productLabel = $this->productLabelRepositoryManager->getEntityByIdentifier($objectIdentifier);
        return $productLabel;
    }

    /**
     * Retrieve productLabels which match a specified criteria.
     */
    public function getList(?SearchCriteriaInterface $searchCriteria = null): SearchResults
    {
        return $this->productLabelRepositoryManager->getEntities($searchCriteria);
    }

    /**
     * Save a productLabel.
     *
     * @throws CouldNotSaveException
     */
    public function save(ProductLabelInterface $object): ProductLabelInterface
    {
        /** @var \Magento\Framework\Model\AbstractModel $object */
        /** @var ProductLabelInterface $productLabel */
        $productLabel = $this->productLabelRepositoryManager->saveEntity($object);
        return $productLabel;
    }

    /**
     * Delete a productLabel by its id.
     *
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $objectId): bool
    {
        return $this->productLabelRepositoryManager->deleteEntityById($objectId);
    }

    /**
     * Delete a productLabel by its identifier.
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteByIdentifier(string $label): bool
    {
        return $this->productLabelRepositoryManager->deleteEntityByIdentifier($label);
    }
}
