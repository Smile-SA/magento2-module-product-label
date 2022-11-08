<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\ResourceModel\ProductLabel\Store;

/**
 * Virtual Attribute store relation read handler.
 */
class SaveHandler implements \Magento\Framework\EntityManager\Operation\ExtensionInterface
{
    /**
     * @inheritdoc
     */
    public function execute($entity, $arguments = [])
    {
        /** @var \Smile\ProductLabel\Model\ResourceModel\ProductLabel $resource */
        $resource = $entity->getResource();

        $resource->saveStoreRelation($entity);

        return $entity;
    }
}
