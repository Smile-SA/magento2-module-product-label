<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\ResourceModel\ProductLabel\Store;

/**
 * Virtual Attribute store relation read handler.
 */
class ReadHandler implements \Magento\Framework\EntityManager\Operation\ExtensionInterface
{
    /**
     * @inheritdoc
     */
    public function execute($entity, $arguments = [])
    {
        /** @var \Smile\ProductLabel\Model\ResourceModel\ProductLabel $resource */
        $resource = $entity->getResource();

        $stores = $resource->getStoreIds($entity);
        $entity->setData('store_id', $stores);
        $entity->setData('stores', $stores);

        return $entity;
    }
}
