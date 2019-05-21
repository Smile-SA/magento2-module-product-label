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
namespace Smile\ProductLabel\Model\ResourceModel\ProductLabel\Store;

/**
 * Virtual Attribute store relation read handler.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class SaveHandler implements \Magento\Framework\EntityManager\Operation\ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute($entity, $arguments = [])
    {
        /** @var \Smile\ProductLabel\Model\ResourceModel\ProductLabel $resource */
        $resource = $entity->getResource();

        $resource->saveStoreRelation($entity);

        return $entity;
    }
}
