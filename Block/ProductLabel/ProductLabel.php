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

namespace Smile\ProductLabel\Block\ProductLabel;

use Magento\Catalog\Model\Product;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Smile\ProductLabel\Option\ProductLabel as ProductLabelOption;

/**
 * Class ProductLabel
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class ProductLabel extends Template implements IdentityInterface
{

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var ProductLabelOption
     */
    protected $productLabelCollection;

    /**
     * ProductLabel constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param Registry                                $registry
     * @param ProductLabelOption                      $productLabelCollection
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        ProductLabelOption $productLabelCollection,
        array $data = []
    )
    {
        $this->registry = $registry;
        $this->productLabelCollection = $productLabelCollection;

        parent::__construct($context, $data);
    }

    /**
     * Get Current Catalog Product
     *
     * @return Product
     */
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    /**
     * Get Attributes Of Current Product
     *
     * @return array
     */
    public function getAttributesOfCurrentProduct()
    {
        $attributesList = array();
        $attributes = $this->getCurrentProduct()->getAttributes();

        foreach ($attributes as $attribute){

            $optionsList = array();
            $optionIds = $this->getCurrentProduct()->getCustomAttribute($attribute->getAttributeCode());

            $attributesList[$attribute->getId()] = [
                'id' => $attribute->getId(),
                'label' => $attribute->getFrontend()->getLabel(),
                'options' => ($optionIds)? $optionIds->getValue() : ''
            ];
            if($optionIds) {
                foreach ($optionIds as $option) {
                    $optionsList [] = $option;
                }
            }
        }
        return $attributesList;
    }

    /**
     * Check if product has product labels
     * If it has, return an array of product labels
     *
     * @return array
     */
    public function getProductLabels()
    {
        $productLabels = array();
        $productLabelList = $this->productLabelCollection->getAllOptions();
        $attributesProduct = $this->getAttributesOfCurrentProduct();

        foreach ($productLabelList as $productLabel) {
            $attributeIdLabel = $productLabel['attribute_id'];
            $optionIdLabel = $productLabel['option_id'];
            foreach ($attributesProduct as $attribute) {
                if (isset($attribute['id']) && ($attributeIdLabel == $attribute['id'])){
                    if (!is_array($attribute['options'])) {
                        if (isset($attribute['options']) && ($optionIdLabel == $attribute['options'])) {
                            $productLabels [] = $productLabel;
                        }
                    }
                }
            }
        }

        return $productLabels;
    }


    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        $identities = [];

        /** @var IdentityInterface $product */
        $product = $this->getCurrentProduct();
        if ($product) {
            $identities = array_merge($identities, $product->getIdentities());
        }
        return $identities;
    }

}