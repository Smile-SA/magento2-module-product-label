<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\Repository;

use Exception;
use Magento\Framework\Api\AbstractExtensibleObject;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface as CollectionProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Data\Collection\AbstractDb as AbstractCollection;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb as AbstractResourceModel;
use Magento\Framework\Phrase;

/**
 * Repository Manager
 */
class Manager
{
    protected CollectionProcessor $collectionProcessor;
    protected AbstractResourceModel $objectResource;
    protected ?string $identifierFieldName = null;
    protected array $cacheById = [];
    protected array $cacheByIdentifier = [];

    /** @var mixed */
    protected $objectFactory;

    /** @var mixed */
    protected $objectCollectionFactory;

    /** @var mixed */
    protected $objectSearchResultsFactory;

    /**
     * Contructor
     *
     * @param mixed $objectFactory
     * @param mixed $objectCollectionFactory
     * @param mixed $objectSearchResultsFactory
     */
    public function __construct(
        CollectionProcessor $collectionProcessor,
        $objectFactory,
        AbstractResourceModel $objectResource,
        $objectCollectionFactory,
        $objectSearchResultsFactory,
        ?string $identifierFieldName = null
    ) {
        $this->collectionProcessor        = $collectionProcessor;
        $this->objectFactory              = $objectFactory;
        $this->objectResource             = $objectResource;
        $this->objectCollectionFactory    = $objectCollectionFactory;
        $this->objectSearchResultsFactory = $objectSearchResultsFactory;
        $this->identifierFieldName        = $identifierFieldName;
    }

    /**
     * Retrieve a entity by its ID.
     *
     * @throws NoSuchEntityException
     */
    public function getEntityById(int $objectId): AbstractModel
    {
        if (!isset($this->cacheById[$objectId])) {
            /** @var AbstractModel $object */
            $object = $this->objectFactory->create();
            $this->objectResource->load($object, $objectId);

            if (!$object->getId()) {
                // Object does not exist.
                throw NoSuchEntityException::singleField('objectId', $objectId);
            }

            $this->cacheById[$object->getId()] = $object;

            if ($this->identifierFieldName !== null) {
                $objectIdentifier                           = $object->getData($this->identifierFieldName);
                $this->cacheByIdentifier[$objectIdentifier] = $object;
            }
        }

        return $this->cacheById[$objectId];
    }

    /**
     * Retrieve a entity by its identifier.
     *
     * @throws NoSuchEntityException
     */
    public function getEntityByIdentifier(string $objectIdentifier): AbstractModel
    {
        if ($this->identifierFieldName === null) {
            throw new NoSuchEntityException(__('The identifier field name is not set'));
        }

        if (!isset($this->cacheByIdentifier[$objectIdentifier])) {
            /** @var AbstractModel $object */
            $object = $this->objectFactory->create();
            $this->objectResource->load($object, $objectIdentifier, $this->identifierFieldName);

            if (!$object->getId()) {
                // Object does not exist.
                throw NoSuchEntityException::singleField('objectIdentifier', $objectIdentifier);
            }

            $this->cacheById[$object->getId()]          = $object;
            $this->cacheByIdentifier[$objectIdentifier] = $object;
        }

        return $this->cacheByIdentifier[$objectIdentifier];
    }

    /**
     * Save entity.
     *
     * @throws CouldNotSaveException
     */
    public function saveEntity(AbstractModel $object): AbstractModel
    {
        /** @var AbstractModel $object */
        try {
            $this->objectResource->save($object);

            unset($this->cacheById[$object->getId()]);
            if ($this->identifierFieldName !== null) {
                $objectIdentifier = $object->getData($this->identifierFieldName);
                unset($this->cacheByIdentifier[$objectIdentifier]);
            }
        } catch (Exception $e) {
            $msg = new Phrase($e->getMessage());
            throw new CouldNotSaveException($msg);
        }

        return $object;
    }

    /**
     * Delete entity.
     *
     * @throws CouldNotDeleteException
     */
    public function deleteEntity(AbstractModel $object): bool
    {
        try {
            $this->objectResource->delete($object);

            unset($this->cacheById[$object->getId()]);
            if ($this->identifierFieldName !== null) {
                $objectIdentifier = $object->getData($this->identifierFieldName);
                unset($this->cacheByIdentifier[$objectIdentifier]);
            }
        } catch (Exception $e) {
            $msg = new Phrase($e->getMessage());
            throw new CouldNotDeleteException($msg);
        }

        return true;
    }

    /**
     * Delete entity by id.
     *
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteEntityById(int $objectId): bool
    {
        return $this->deleteEntity($this->getEntityById($objectId));
    }

    /**
     * Delete entity by identifier.
     *
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteEntityByIdentifier(string $objectIdentifier): bool
    {
        return $this->deleteEntity($this->getEntityByIdentifier($objectIdentifier));
    }

    /**
     * Retrieve not eav entities which match a specified criteria.
     */
    public function getEntities(?SearchCriteriaInterface $searchCriteria = null): SearchResults
    {
        /** @var AbstractCollection $collection */
        $collection = $this->objectCollectionFactory->create();

        /** @var SearchResults $searchResults */
        $searchResults = $this->objectSearchResultsFactory->create();

        if ($searchCriteria) {
            $searchResults->setSearchCriteria($searchCriteria);
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        // Load the collection.
        $collection->load();

        // Build the result.
        $searchResults->setTotalCount($collection->getSize());

        /** @var AbstractExtensibleObject[] $items */
        $items = $collection->getItems();
        $searchResults->setItems($items);

        return $searchResults;
    }
}
