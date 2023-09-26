<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\ProductLabel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Smile\ProductLabel\Helper\Data as DataHelper;

/**
 * Class ReadHandler Locator
 */
class ReadHandler implements ExtensionInterface
{
    protected DataHelper $dataHelper;

    public function __construct(DataHelper $dataHelper)
    {
        $this->dataHelper = $dataHelper;
    }

    /**
     * @inheritDoc
     */
    public function execute($entity, $arguments = [])
    {
        /** @var ProductInterface $entity */
        $extension = $entity->getExtensionAttributes();

        // @phpstan-ignore-next-line PHPStan can't deal with generated class
        if ($extension->getProductLabels() !== null) {
            return $entity;
        }

        $dataHelper = $this->dataHelper;
        $productLabels = $dataHelper->getProductLabels($entity);
        // @phpstan-ignore-next-line PHPStan can't deal with generated class
        $extension->setProductLabels($productLabels);
        $entity->setExtensionAttributes($extension);

        return $entity;
    }
}
