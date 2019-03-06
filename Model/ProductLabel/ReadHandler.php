<?php

namespace Smile\ProductLabel\Model\ProductLabel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Smile\ProductLabel\Helper\Data as DataHelper;

/**
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class ReadHandler implements ExtensionInterface
{

    /**
     * @var DataHelper
     */
    protected $dataHelper;

    /**
     * ReadHandler constructor.
     * @param DataHelper $dataHelper
     */
    public function __construct(DataHelper $dataHelper)
    {
        $this->dataHelper = $dataHelper;
    }


    /**
     * Perform action on relation/extension attribute
     *
     *
     * @param $product
     * @param array $arguments
     * @return ProductInterface|object
     */
    public function execute($product, $arguments = [])
    {
        /** @var ProductInterface $product */
        $extension = $product->getExtensionAttributes();

        if ($extension->getProductLabels() !== null)
            return $product;

        $productlabels = $this->dataHelper->getProductProductLabels($product);

        $extension->setProductLabels($productlabels);

        $product->setExtensionAttributes($extension);

        return $product;


    }
}