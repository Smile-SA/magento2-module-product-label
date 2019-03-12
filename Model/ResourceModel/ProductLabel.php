<?php
/**
 * DISCLAIMER
 *
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
     * @param Context       $context
     * @param EntityManager $entityManager
     * @param MetadataPool  $metadataPool
     * @param null          $connectionName
     */
    public function __construct(
        Context $context,
        EntityManager $entityManager,
        MetadataPool $metadataPool,
        $connectionName = null
    )
    {
        parent::__construct($context, $connectionName);

        $this->entityManager = $entityManager;
        $this->metadataPool = $metadataPool;
    }

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     *
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(
            ProductLabelInterface::TABLE_NAME,
            ProductLabelInterface::PRODUCTLABEL_ID);
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
     * @param AbstractModel $object
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
     * @param AbstractModel $object
     *
     * @return $this
     */
    public function delete(AbstractModel $object)
    {
        $this->entityManager->delete($object);

        return $this;
    }

}