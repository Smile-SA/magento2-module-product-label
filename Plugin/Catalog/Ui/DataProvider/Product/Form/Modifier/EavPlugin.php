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

namespace Smile\ProductLabel\Plugin\Catalog\Ui\DataProvider\Product\Form\Modifier;

use \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory as ProductLabelCollectionFactory;

/**
 * Smile Product Label form Ui component plugin.
 * Used to add a tooltip around virtual attributes.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class EavPlugin
{
    /**
     * Template for tooltip added to virtual attributes in product edit form.
     */
    const TOOLTIP_TEMPLATE = 'Smile_ProductLabel/form/element/helper/tooltip';

    /**
     * @var \Magento\Framework\Stdlib\ArrayManager
     */
    private $arrayManager;

    /**
     * @var ProductLabelCollectionFactory
     */
    private $plabelCollectionFactory;

    /**
     * EavPlugin constructor.
     *
     * @param \Magento\Framework\Stdlib\ArrayManager $arrayManager            Array Manager
     * @param ProductLabelCollectionFactory          $plabelCollectionFactory Collection Factory
     */
    public function __construct(
        \Magento\Framework\Stdlib\ArrayManager $arrayManager,
        ProductLabelCollectionFactory $plabelCollectionFactory
    ) {
        $this->arrayManager          = $arrayManager;
        $this->plabelCollectionFactory = $plabelCollectionFactory;
    }

    /**
     * Fix custom entity field meta.
     *
     * @param \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Eav $subject   Object.
     * @param callable                                                   $proceed   Original method.
     * @param \Magento\Catalog\Api\Data\ProductAttributeInterface        $attribute Attribute.
     * @param string                                                     $groupCode Group code.
     * @param int                                                        $sortOrder Sort order.
     *
     * @return array
     */
    public function aroundSetupAttributeMeta(
        \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Eav $subject,
        callable $proceed,
        \Magento\Catalog\Api\Data\ProductAttributeInterface $attribute,
        $groupCode,
        $sortOrder
    ) {
        $meta = $proceed($attribute, $groupCode, $sortOrder);

        if ($this->hasCalculatedValues($attribute)) {
            $configPath = ltrim($subject::META_CONFIG_PATH, \Magento\Framework\Stdlib\ArrayManager::DEFAULT_PATH_DELIMITER);

            $fieldConfig = [
                'tooltip' => [
                    'description' => __("This attribute is linked to a product label."),
                ],
                'tooltipTpl' => self::TOOLTIP_TEMPLATE,
            ];

            $meta = $this->arrayManager->merge($configPath, $meta, $fieldConfig);
        }

        return $meta;
    }

    /**
     * Check if an attribute has calculated values. (true if it has product labels based on this attribute).
     *
     * @param \Magento\Catalog\Api\Data\ProductAttributeInterface $attribute Attribute
     *
     * @return bool
     */
    private function hasCalculatedValues(\Magento\Catalog\Api\Data\ProductAttributeInterface $attribute)
    {
        $result = false;

        if ($attribute->getAttributeId()) {
            $productLabelCollection = $this->plabelCollectionFactory->create();
            $productLabelCollection->addAttributeFilter($attribute);

            $result = $productLabelCollection->getSize() > 0;
        }

        return $result;
    }
}
