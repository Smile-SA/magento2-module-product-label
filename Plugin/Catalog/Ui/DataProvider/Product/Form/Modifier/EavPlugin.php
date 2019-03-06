<?php
/**
 * Smile Elastic Suite Virtual Attribute product form Ui component plugin.
 * Used to add a tooltip around virtual attributes.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */

namespace Smile\ProductLabel\Plugin\Catalog\Ui\DataProvider\Product\Form\Modifier;

use \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory as ProductLabelCollectionFactory;

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
     * Constructor.
     *
     * @param \Magento\Framework\Stdlib\ArrayManager $arrayManager          Array manager util.
     * @param ProductLabelCollectionFactory                  $plabelCollectionFactory Rule Collection Factory
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
                    'description' => __("This attribute has values that can be automatically set by virtual attribute rules. "
                        . "Modifying it could lead to potential data loss on next occurence of rules calculation."),
                ],
                'tooltipTpl' => self::TOOLTIP_TEMPLATE,
            ];

            $meta = $this->arrayManager->merge($configPath, $meta, $fieldConfig);
        }

        return $meta;
    }

    /**
     * Check if an attribute has calculated values. (true if it has rules based on this attribute).
     *
     * @param \Magento\Catalog\Api\Data\ProductAttributeInterface $attribute Attribute
     *
     * @return bool
     */
    private function hasCalculatedValues(\Magento\Catalog\Api\Data\ProductAttributeInterface $attribute)
    {
        $result = false;

        if ($attribute->getAttributeId()) {
            $ruleCollection = $this->plabelCollectionFactory->create();
            $ruleCollection->addAttributeFilter($attribute);

            $result = $ruleCollection->getSize() > 0;
        }

        return $result;
    }
}
