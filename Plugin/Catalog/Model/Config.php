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

namespace Smile\ProductLabel\Plugin\Catalog\Model;

/**
 * Plugin on Catalog Configuration to enforce loading of all attributes used for product labels rules to be loaded on listing pages.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class Config
{
    /**
     * Product Attributes used in product listing
     *
     * @var array
     */
    private $usedInProductListing;

    /**
     * Eav config
     *
     * @var \Magento\Eav\Model\Config
     */
    private $eavConfig;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Eav\Attribute
     */
    private $attributeFactory;

    /**
     * @var \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory
     */
    private $productLabelCollectionFactory;

    /**
     * Config constructor.
     *
     * @param \Magento\Eav\Model\Config                                              $eavConfig                     EAV Config
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute                     $attributeFactory              Attributes Factory
     * @param \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory $productLabelCollectionFactory Product Label Factory
     */
    public function __construct(
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory,
        \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory $productLabelCollectionFactory
    ) {
        $this->eavConfig                     = $eavConfig;
        $this->attributeFactory              = $attributeFactory;
        $this->productLabelCollectionFactory = $productLabelCollectionFactory;
    }

    /**
     * Add all attributes used for picto/labels into the list of attributes used in product listing.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param \Magento\Catalog\Model\Config $subject The Catalog config
     * @param array                         $result  The result of $subject->getAttributesUsedInProductListing
     *
     * @return array
     */
    public function afterGetAttributesUsedInProductListing(\Magento\Catalog\Model\Config $subject, $result)
    {
        if ($this->usedInProductListing === null) {
            $this->usedInProductListing = $result;
            $entityType                 = \Magento\Catalog\Model\Product::ENTITY;

            /** @var \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory */
            $productLabelsCollection = $this->productLabelCollectionFactory->create();
            // Here you have all the attribute ids that are used to build product label rules.
            $attributeIds = $productLabelsCollection->getAllAttributeIds();

            // Filter the collection on these attributes only.
            $attributesDataExtra = $this->attributeFactory->getCollection()
                ->addFieldToFilter('attribute_id', ['in' => $attributeIds])->getData();

            $this->eavConfig->importAttributesData($entityType, $attributesDataExtra);

            foreach ($attributesDataExtra as $attributeData) {
                $attributeCode                              = $attributeData['attribute_code'];
                $this->usedInProductListing[$attributeCode] = $this->eavConfig->getAttribute(
                    $entityType,
                    $attributeCode
                );
            }
        }

        return $this->usedInProductListing;
    }
}
