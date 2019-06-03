<?php
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Model\ResourceModel;

use Magento\Framework\DB\Select;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Model\AbstractModel;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;

/**
 * Collection Resource Model Class: ProductLabel
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class ProductLabel extends AbstractDb
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * Resource initialization
     *
     * @param Context       $context        Context
     * @param EntityManager $entityManager  Entity Manager
     * @param MetadataPool  $metadataPool   Metadata Pool
     * @param null          $connectionName Connection Name
     */
    public function __construct(
        Context $context,
        EntityManager $entityManager,
        MetadataPool $metadataPool,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);

        $this->entityManager = $entityManager;
        $this->metadataPool  = $metadataPool;
    }

    /**
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    public function getConnection()
    {
        $connectionName = $this->metadataPool->getMetadata(ProductLabelInterface::class)->getEntityConnectionName();

        return $this->_resources->getConnectionByName($connectionName);
    }

    /**
     * Save Product Label
     *
     * @param AbstractModel $object Product Label
     *
     * @return $this
     */
    public function save(AbstractModel $object)
    {
        $this->entityManager->save($object);

        return $this;
    }

    /**
     * Delete Product Label
     *
     * @param AbstractModel $object Product Label
     *
     * @return $this
     */
    public function delete(AbstractModel $object)
    {
        $this->entityManager->delete($object);

        return $this;
    }

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(
            ProductLabelInterface::TABLE_NAME,
            ProductLabelInterface::PRODUCTLABEL_ID
        );
    }

    /**
     * Persist relation between a given object and his product labels.
     *
     * @param object $entity The product label
     * @param array $arguments
     * @return object
     * @throws \Exception
     */
    public function saveStoreRelation($entity, $arguments = [])
    {
        $entityMetadata = $this->metadataPool->getMetadata(ProductLabelInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $connection = $entityMetadata->getEntityConnection();

        $oldStores = $this->getStoreIds((int)$entity->getId());
        $newStores = (array) $entity->getStores();

        $table = $this->getTable(ProductLabelInterface::STORE_TABLE_NAME);

        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = [
                $linkField . ' = ?' => (int) $entity->getData($linkField),
                'store_id IN (?)' => $delete,
            ];
            $connection->delete($table, $where);
        }

        $insert = array_diff($newStores, $oldStores);
        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = [
                    $this->getIdFieldName() => (int) $entity->getData($linkField),
                    'store_id'              => (int) $storeId,
                ];
            }
            $this->getConnection()->insertMultiple($table, $data);
        }

        return $entity;
    }

    /**
     * Retrieve store ids associated to a given product label.
     *
     * @param int $id
     * @return array
     */
    public function getStoreIds($id)
    {
        $connection = $this->getConnection();

        $entityMetadata = $this->metadataPool->getMetadata(ProductLabelInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $select = $connection->select()
            ->from(['pls' => $this->getTable(ProductLabelInterface::STORE_TABLE_NAME)], 'store_id')
            ->join(
                ['pl' => $this->getMainTable()],
                'pls.' . $linkField . ' = pl.' . $linkField,
                []
            )
            ->where('pl.' . $entityMetadata->getIdentifierField() . ' = :product_label_id');

        return $connection->fetchCol($select, ['product_label_id' => (int) $id]);
    }

}
