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

    /**
     * ReadHandler constructor.
     *
     * @param DataHelper $dataHelper Helper
     */
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

        if ($extension->getProductLabels() !== null) {
            return $entity;
        }

        /** @var DataHelper $dataHelper */
        $dataHelper = $this->dataHelper;
        $productLabels = $dataHelper->getProductLabels($entity);

        $extension->setProductLabels($productLabels);

        $entity->setExtensionAttributes($extension);

        return $entity;
    }
}
