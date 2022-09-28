<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Plugin\Catalog\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Eav;
use Magento\Framework\Stdlib\ArrayManager;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory as ProductLabelCollectionFactory;

/**
 * Smile Product Label form Ui component plugin.
 * Used to add a tooltip around virtual attributes.
 */
class EavPlugin
{
    /**
     * Template for tooltip added to virtual attributes in product edit form.
     */
    private const TOOLTIP_TEMPLATE = 'Smile_ProductLabel/form/element/helper/tooltip';

    private ArrayManager $arrayManager;

    private ProductLabelCollectionFactory $plabelCollectionFactory;

    /**
     * EavPlugin constructor.
     *
     * @param ArrayManager $arrayManager            Array Manager
     * @param ProductLabelCollectionFactory          $plabelCollectionFactory Collection Factory
     */
    public function __construct(
        ArrayManager $arrayManager,
        ProductLabelCollectionFactory $plabelCollectionFactory
    ) {
        $this->arrayManager          = $arrayManager;
        $this->plabelCollectionFactory = $plabelCollectionFactory;
    }

    /**
     * Fix custom entity field meta.
     *
     * @param Eav $subject   Object.
     * @param callable $proceed Original method.
     * @param ProductAttributeInterface $attribute Attribute.
     * @param string $groupCode Group code.
     * @param int $sortOrder Sort order.
     * @return array
     */
    public function aroundSetupAttributeMeta(
        Eav $subject,
        callable $proceed,
        ProductAttributeInterface $attribute,
        string $groupCode,
        int $sortOrder
    ): array {
        $meta = $proceed($attribute, $groupCode, $sortOrder);

        if ($this->hasCalculatedValues($attribute)) {
            $configPath = ltrim(
                $subject::META_CONFIG_PATH,
                ArrayManager::DEFAULT_PATH_DELIMITER
            );

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
     * @param ProductAttributeInterface $attribute Attribute
     */
    private function hasCalculatedValues(ProductAttributeInterface $attribute): bool
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
