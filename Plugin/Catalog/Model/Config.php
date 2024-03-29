<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Plugin\Catalog\Model;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Eav\Model\Config as EavConfigModel;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory;

/**
 * Plugin on Catalog Configuration
 * to enforce loading of all attributes used for product labels rules to be loaded on listing pages.
 */
class Config
{
    /** Product Attributes used in product listing */
    private array $usedInProductListing;
    private EavConfigModel $eavConfig;
    private Attribute $attributeFactory;
    private CollectionFactory $productLabelCollectionFactory;

    public function __construct(
        EavConfigModel    $eavConfig,
        Attribute         $attributeFactory,
        CollectionFactory $productLabelCollectionFactory
    ) {
        $this->eavConfig = $eavConfig;
        $this->attributeFactory = $attributeFactory;
        $this->productLabelCollectionFactory = $productLabelCollectionFactory;
        $this->usedInProductListing = [];
    }

    /**
     * Add all attributes used for picto/labels into the list of attributes used in product listing.
     */
    public function afterGetAttributesUsedInProductListing(\Magento\Catalog\Model\Config $subject, array $result): array
    {
        if ($this->usedInProductListing == null) {
            $this->usedInProductListing = $result;
            $entityType = Product::ENTITY;

            $productLabelsCollection = $this->productLabelCollectionFactory->create();
            // Here you have all the attribute ids that are used to build product label rules.

            $attributeIds = $productLabelsCollection->getAllAttributeIds();

            // Filter the collection on these attributes only.
            $attributesDataExtra = $this->attributeFactory->getCollection()
                ->addFieldToFilter('attribute_id', ['in' => $attributeIds])->getData();

            $this->eavConfig->importAttributesData($entityType, $attributesDataExtra);

            foreach ($attributesDataExtra as $attributeData) {
                $attributeCode = $attributeData['attribute_code'];
                $this->usedInProductListing[$attributeCode] = $this->eavConfig->getAttribute(
                    $entityType,
                    $attributeCode
                );
            }
        }

        return $this->usedInProductListing;
    }
}
