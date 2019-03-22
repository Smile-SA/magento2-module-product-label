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
use Magento\Catalog\Api\Data\ProductInterface;
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
     * @var \Smile\ProductLabel\Model\ImageLabel\Image
     */
    protected $imageHelper;

    /**
     * @var ProductInterface
     */
    protected $product;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $productRepository;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * ProductLabel constructor.
     *
     * @param \Magento\Backend\Block\Template\Context    $context
     * @param Registry                                   $registry
     * @param ProductLabelOption                         $productLabelCollection
     * @param \Smile\ProductLabel\Model\ImageLabel\Image $imageHelper
     * @param \Magento\Catalog\Model\ProductRepository   $productRepository
     * @param \Magento\Framework\App\RequestInterface    $request
     * @param array                                      $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        ProductLabelOption $productLabelCollection,
        \Smile\ProductLabel\Model\ImageLabel\Image $imageHelper,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Framework\App\RequestInterface $request,
        array $data = []
    )
    {
        $this->registry = $registry;
        $this->productLabelCollection = $productLabelCollection;
        $this->imageHelper = $imageHelper;
        $this->productRepository = $productRepository;
        $this->request = $request;

        parent::__construct($context, $data);
    }

    /**
     * Get Current View
     *
     * @return string
     */
    public function getCurrentView()
    {
        if ($this->request->getControllerName('controller') == 'product') {
            return 'product';
        } else {
            return 'category';
        }
    }

    /**
     * Set Product
     *
     * @param ProductInterface $product
     *
     * @return $this
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * Get Product By Id
     *
     * @param $id
     *
     * @return ProductInterface|mixed
     */
    public function getProductById($id)
    {
        return $this->productRepository->getById($id);
    }

    /**
     * Get Current Product
     *
     * @return Product|ProductInterface
     */
    public function getCurrentProduct()
    {
        if(!empty($this->registry->registry('current_product'))) {
            return $this->registry->registry('current_product');
        } else {
            return $this->getProductById($this->product->getId());
        }
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

        foreach ($attributes as $attribute) {
            $optionIds = $this->getCurrentProduct()->getCustomAttribute($attribute->getAttributeCode());

            $attributesList[$attribute->getId()] = [
                'id' => $attribute->getId(),
                'label' => $attribute->getFrontend()->getLabel(),
                'options' => ($optionIds) ? $optionIds->getValue() : ''
            ];
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
            if ($productLabel['is_active']) {
                $attributeIdLabel = $productLabel['attribute_id'];
                $optionIdLabel = $productLabel['option_id'];
                foreach ($attributesProduct as $attribute) {
                    if (isset($attribute['id']) && ($attributeIdLabel == $attribute['id'])) {
                        if (!is_array($attribute['options'])) {
                            if (isset($attribute['options']) && ($optionIdLabel == $attribute['options'])) {
                                $productLabels [] = $productLabel;
                            }
                        }
                    }
                }
            }
        }

        return $productLabels;
    }

    /**
     * Get Image URL of product label
     *
     * @param $imageName
     *
     * @return string
     */
    public function getImageUrl($imageName)
    {
       return $this->imageHelper->getBaseUrl().'/'.$imageName;
    }


    public function getDisplayOn()
    {

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