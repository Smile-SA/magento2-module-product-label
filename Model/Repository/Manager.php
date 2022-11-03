<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\Repository;

use Magento\Framework\Api\AbstractExtensibleObject;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface as CollectionProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;
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

    /**
     * @var mixed
     */
    protected $objectFactory;

    protected AbstractResourceModel $objectResource;

    /**
     * @var mixed
     */
    protected $objectCollectionFactory;

    /**
     * @var mixed
     */
    protected $objectSearchResultsFactory;

    protected ?string $identifierFieldName = null;

    /**
     * @var array
     */
    protected array $cacheById = [];

    /**
     * @var array
     */
    protected array $cacheByIdentifier = [];

    /**
     * Manager constructor.
     *
     * @param CollectionProcessor   $collectionProcessor        Collection Processor
     * @param mixed                 $objectFactory              Object Factory
     * @param AbstractResourceModel $objectResource             Object Resource
     * @param mixed                 $objectCollectionFactory    CollectionFactory
     * @param mixed                 $objectSearchResultsFactory Searchresult Factory
     * @param null                  $identifierFieldName        Identifier Field Name
     */
    public function __construct(
        CollectionProcessor $collectionProcessor,
        $objectFactory,
        AbstractResourceModel $objectResource,
        $objectCollectionFactory,
        $objectSearchResultsFactory,
        $identifierFieldName = null
    ) {
        $this->collectionProcessor = $collectionProcessor;

        $this->objectFactory              = $objectFactory;
        $this->objectResource             = $objectResource;
        $this->objectCollectionFactory    = $objectCollectionFactory;
        $this->objectSearchResultsFactory = $objectSearchResultsFactory;
        $this->identifierFieldName        = $identifierFieldName;
    }

    /**
     * Retrieve a entity by its ID.
     *
     * @param int $objectId The object Id
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @SuppressWarnings(PMD.StaticAccess)
     */
    public function getEntityById(int $objectId): \Magento\Framework\Model\AbstractModel
    {
        if (!isset($this->cacheById[$objectId])) {
            /** @var \Magento\Framework\Model\AbstractModel $object */
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
     * @param string $objectIdentifier The Object Id
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @SuppressWarnings(PMD.StaticAccess)
     */
    public function getEntityByIdentifier(string $objectIdentifier): \Magento\Framework\Model\AbstractModel
    {
        if ($this->identifierFieldName === null) {
            throw new NoSuchEntityException(__('The identifier field name is not set'));
        }

        if (!isset($this->cacheByIdentifier[$objectIdentifier])) {
            /** @var \Magento\Framework\Model\AbstractModel $object */
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
     * @param AbstractModel $object The Object
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
        } catch (\Exception $e) {
            $msg = new Phrase($e->getMessage());
            throw new CouldNotSaveException($msg);
        }

        return $object;
    }

    /**
     * Delete entity.
     *
     * @param AbstractModel $object The Object
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
        } catch (\Exception $e) {
            $msg = new Phrase($e->getMessage());
            throw new CouldNotDeleteException($msg);
        }

        return true;
    }

    /**
     * Delete entity by id.
     *
     * @param int $objectId Object Id
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
     * @param string $objectIdentifier Object Id
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteEntityByIdentifier(string $objectIdentifier): bool
    {
        return $this->deleteEntity($this->getEntityByIdentifier($objectIdentifier));
    }

    /**
     * Retrieve not eav entities which match a specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria SearchCriteria
     */
    public function getEntities(?SearchCriteriaInterface $searchCriteria = null): \Magento\Framework\Api\SearchResults
    {
        /** @var AbstractCollection $collection */
        $collection = $this->objectCollectionFactory->create();

        /** @var \Magento\Framework\Api\SearchResults $searchResults */
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
