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
     * Perform action on relation/extension attribute
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param ProductInterface $product   Catalog Product Object
     * @param array            $arguments Array of Arguments
     * @return ProductInterface|object
     */
    public function execute(ProductInterface $product, array $arguments = [])
    {
        /** @var ProductInterface $product */
        $extension = $product->getExtensionAttributes();

        if ($extension->getProductLabels() !== null) {
            return $product;
        }

        $productLabels = $this->dataHelper->getProductLabels($product);

        $extension->setProductLabels($productLabels);

        $product->setExtensionAttributes($extension);

        return $product;
    }
}
