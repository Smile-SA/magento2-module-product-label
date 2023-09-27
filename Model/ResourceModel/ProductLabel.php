<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\ResourceModel;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;

/**
 * Collection Resource Model Class: ProductLabel
 */
class ProductLabel extends AbstractDb
{
    protected Json $jsonSerializer;
    protected EntityManager $entityManager;
    protected MetadataPool $metadataPool;
    private StoreManagerInterface $storeManager;

    public function __construct(
        Context $context,
        EntityManager $entityManager,
        MetadataPool $metadataPool,
        StoreManagerInterface $storeManager,
        Json $jsonSerializer,
        ?string $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->entityManager = $entityManager;
        $this->metadataPool  = $metadataPool;
        $this->storeManager  = $storeManager;
        $this->serializer = $jsonSerializer;
    }

    /**
     * Get connection
     *
     * @throws \Exception
     */
    public function getConnection(): AdapterInterface
    {
        $connectionName = $this->metadataPool->getMetadata(ProductLabelInterface::class)->getEntityConnectionName();

        return $this->_resources->getConnectionByName($connectionName);
    }

    /**
     * Save Product Label
     *
     * @throws \Exception
     */
    public function save(AbstractModel $object): self
    {
        $this->entityManager->save($object);

        return $this;
    }

    /**
     * Delete Product Label
     *
     * @throws \Exception
     */
    public function delete(AbstractModel $object): self
    {
        $this->entityManager->delete($object);

        return $this;
    }

    /**
     * Persist relation between a given product label and his stores.
     *
     * @throws LocalizedException
     */
    public function saveStoreRelation(AbstractModel $object): AbstractModel
    {
        $oldStores = $this->getStoreIds($object);
        $newStores = $object->getStores();

        $this->checkUnicity($object, $newStores);
        $table = $this->getTable(ProductLabelInterface::STORE_TABLE_NAME);

        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = [
                $this->getIdFieldName() . ' = ?' => (int) $object->getData($this->getIdFieldName()),
                'store_id IN (?)'                => $delete,
            ];
            $this->getConnection()->delete($table, $where);
        }

        $insert = array_diff($newStores, $oldStores);
        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = [
                    $this->getIdFieldName() => (int) $object->getData($this->getIdFieldName()),
                    'store_id'              => (int) $storeId,
                ];
            }

            $this->getConnection()->insertMultiple($table, $data);
        }

        return $object;
    }

    /**
     * Retrieve store ids associated to a given product label.
     *
     * @throws LocalizedException
     */
    public function getStoreIds(AbstractModel $object): array
    {
        $connection = $this->getConnection();

        $select = $connection->select()
            ->from(['pls' => $this->getTable(ProductLabelInterface::STORE_TABLE_NAME)], 'store_id')
            ->join(
                ['pl' => $this->getMainTable()],
                'pls.' . $this->getIdFieldName() . ' = pl.' . $this->getIdFieldName(),
                []
            )
            ->where("pl." . $this->getIdFieldName() . " = :{$this->getIdFieldName()}");

        return $connection->fetchCol($select, [$this->getIdFieldName() => (int) $object->getId()]);
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ProductLabelInterface::TABLE_NAME, ProductLabelInterface::PRODUCTLABEL_ID);
    }

    /**
     * Check unicity between a product label and stores.
     * Unique constraint is : product_label_id / attribute_id / option_id / store_id
     * A product label can also not be created for store 0 (all store views) if other exists for specific stores.
     *
     * @throws AlreadyExistsException|LocalizedException
     */
    private function checkUnicity(AbstractModel $object, array $stores): bool
    {
        $isDefaultStore = $this->storeManager->isSingleStoreMode()
            || array_search(Store::DEFAULT_STORE_ID, $stores) !== false;

        if (!$isDefaultStore) {
            $stores[] = Store::DEFAULT_STORE_ID;
        }

        $select = $this->getConnection()->select()
            ->from(['pl' => $this->getMainTable()])
            ->join(
                ['pls' => $this->getTable(ProductLabelInterface::STORE_TABLE_NAME)],
                'pl.' . $this->getIdFieldName() . ' = pls.' . $this->getIdFieldName(),
                [ProductLabelInterface::STORE_ID]
            )
            ->where(
                'pl.' . ProductLabelInterface::ATTRIBUTE_ID . ' = ?  ',
                $object->getData(ProductLabelInterface::ATTRIBUTE_ID)
            )
            ->where(
                'pl.' . ProductLabelInterface::OPTION_ID . ' = ?  ',
                $object->getData(ProductLabelInterface::OPTION_ID)
            );

        if (!$isDefaultStore) {
            $select->where('pls.store_id IN (?)', $stores);
        }

        if ($object->getId()) {
            $select->where('pl.' . $this->getIdFieldName() . ' <> ?', $object->getId());
        }

        $row = $this->getConnection()->fetchRow($select);
        if ($row) {
            $error = __(
                'Label for attribute %1, option %2, and store %3  already exist.',
                [
                    $object->getData(ProductLabelInterface::ATTRIBUTE_ID),
                    $object->getData(ProductLabelInterface::OPTION_ID),
                    $row[ProductLabelInterface::STORE_ID],
                ]
            );

            throw new AlreadyExistsException($error);
        }

        return true;
    }
}
