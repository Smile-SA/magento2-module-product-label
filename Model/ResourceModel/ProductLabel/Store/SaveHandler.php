<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\ResourceModel\ProductLabel\Store;

use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel;

/**
 * Virtual Attribute store relation read handler.
 */
class SaveHandler implements ExtensionInterface
{
    /**
     * @inheritdoc
     */
    public function execute($entity, $arguments = [])
    {
        /** @var ProductLabel $resource */
        $resource = $entity->getResource();
        $resource->saveStoreRelation($entity);

        return $entity;
    }
}
