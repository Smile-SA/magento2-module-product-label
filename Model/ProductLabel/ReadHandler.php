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

namespace Smile\ProductLabel\Model\ProductLabel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Smile\ProductLabel\Helper\Data as DataHelper;

/**
 * Class ReadHandler
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
     *
     * @param ProductInterface $product   Catalog Product Object
     * @param array            $arguments Array of Arguments
     *
     * @return ProductInterface|object
     */
    public function execute($product, $arguments = [])
    {
        /** @var ProductInterface $product */
        $extension = $product->getExtensionAttributes();

        if ($extension->getProductLabels() !== null) {
            return $product;
        }

        $productLabels = $this->dataHelper->getProductPLabels($product);

        $extension->setProductLabels($productLabels);

        $product->setExtensionAttributes($extension);

        return $product;
    }
}
