<?php

declare(strict_types=1);

/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Block\ProductLabel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory as ProductLabelCollectionFactory;

/**
 * Class ProductLabel
 *
 * @category  Smile
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class ProductLabel extends Template implements IdentityInterface
{
    protected Registry $registry;

    protected ProductLabelCollectionFactory $productLabelCollectionFactory;

    protected \Smile\ProductLabel\Model\ImageLabel\Image $imageHelper;

    protected ProductInterface $product;

    private \Magento\Framework\App\CacheInterface $cache;

    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    /**
     * ProductLabel constructor.
     *
     * @param \Magento\Backend\Block\Template\Context    $context                       Block context
     * @param Registry                                   $registry                      Registry
     * @param \Smile\ProductLabel\Model\ImageLabel\Image $imageHelper                   Image Helper
     * @param ProductLabelCollectionFactory              $productLabelCollectionFactory Product Label Collection Factory
     * @param \Magento\Framework\App\CacheInterface      $cache                         Cache Interface
     * @param array                                      $data                          Block data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Smile\ProductLabel\Model\ImageLabel\Image $imageHelper,
        ProductLabelCollectionFactory $productLabelCollectionFactory,
        \Magento\Framework\App\CacheInterface $cache,
        array $data = []
    ) {
        $this->registry                      = $registry;
        $this->imageHelper                   = $imageHelper;
        $this->productLabelCollectionFactory = $productLabelCollectionFactory;
        $this->cache                         = $cache;
        $this->storeManager                  = $context->getStoreManager();

        parent::__construct($context, $data);
    }

    /**
     * Get Current View
     */
    public function getCurrentView(): string
    {
        $view = ProductLabelInterface::PRODUCTLABEL_DISPLAY_LISTING;
        if ($this->getRequest()->getControllerName('controller') == 'product') {
            $view = ProductLabelInterface::PRODUCTLABEL_DISPLAY_PRODUCT;
        }

        return $view;
    }

    /**
     * Get labels block wrapper class
     */
    public function getWrapperClass(): string
    {
        $class = 'listing';

        if ($this->getCurrentView() === ProductLabelInterface::PRODUCTLABEL_DISPLAY_PRODUCT) {
            $class = 'product';
        }

        return $class;
    }

    /**
     * Set Product
     *
     * @param ProductInterface $product The product
     * @return $this
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get Product
     *
     * @return Product|ProductInterface|null
     */
    public function getProduct()
    {
        if (null === $this->product) {
            $this->product = $this->registry->registry('current_product');
        }

        return $this->product;
    }

    /**
     * Get Attributes Of Current Product
     *
     * @return array
     */
    public function getAttributesOfCurrentProduct(): array
    {
        $attributesList = [];
        $attributeIds   = array_column($this->getProductLabelsList(), 'attribute_id');
        $productEntity  = $this->getProduct()->getResourceCollection()->getEntity();

        foreach ($attributeIds as $attributeId) {
            $attribute = $productEntity->getAttribute($attributeId);
            if ($attribute) {
                $optionIds = $this->getProduct()->getCustomAttribute($attribute->getAttributeCode());

                $attributesList[$attribute->getId()] = [
                    'id'      => $attribute->getId(),
                    'label'   => $attribute->getFrontend()->getLabel(),
                    'options' => $optionIds ? $optionIds->getValue() : '',
                ];
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
    public function getProductLabels(): array
    {
        $productLabels     = [];
        $productLabelList  = $this->getProductLabelsList();
        $attributesProduct = $this->getAttributesOfCurrentProduct();

        foreach ($productLabelList as $productLabel) {
            $attributeIdLabel = $productLabel['attribute_id'];
            $optionIdLabel    = $productLabel['option_id'];
            foreach ($attributesProduct as $attribute) {
                if (isset($attribute['id']) && ($attributeIdLabel == $attribute['id'])) {
                    $options = $attribute['options'] ?? [];
                    if (!is_array($options)) {
                        $options = explode(',', $options);
                    }
                    if (in_array($optionIdLabel, $options) && in_array($this->getCurrentView(), $productLabel['display_on'])) {
                        $productLabel['class'] = $this->getCssClass($productLabel);
                        $productLabel['image'] = $this->getImageUrl($productLabel['image']);
                        $class = $this->getCssClass($productLabel);
                        $productLabels[$class][] = $productLabel;
                    }
                }
            }
        }

        return $productLabels;
    }

    /**
     * Get Image URL of product label
     *
     * @param string $imageName Image Name
     */
    public function getImageUrl(string $imageName): string
    {
        return $this->imageHelper->getBaseUrl() . '/' . $imageName;
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities(): array
    {
        $identities = [];

        /** @var IdentityInterface $product */
        $product = $this->getProduct();
        if ($product) {
            $identities = array_merge($identities, $product->getIdentities(), [\Smile\ProductLabel\Model\ProductLabel::CACHE_TAG]);
        }

        return $identities;
    }

    /**
     * Fetch proper css class according to current label and view.
     *
     * @param array $productLabel A product Label
     */
    private function getCssClass(array $productLabel): string
    {
        $class = '';

        if ($this->getCurrentView() === ProductLabelInterface::PRODUCTLABEL_DISPLAY_PRODUCT) {
            $class = $productLabel['position_product_view'] . ' product';
        }

        if ($this->getCurrentView() === ProductLabelInterface::PRODUCTLABEL_DISPLAY_LISTING) {
            $class = $productLabel['position_category_list'] . ' category';
        }

        return $class;
    }

    /**
     * Fetch product labels list : the list of all enabled product labels.
     * Fetched only once and put in cache.
     *
     * @return array
     */
    private function getProductLabelsList(): array
    {
        $storeId          = $this->getStoreId();
        $cacheKey         = 'smile_productlabel_frontend_' . $storeId;
        $productLabelList = $this->cache->load($cacheKey);

        if (is_string($productLabelList)) {
            $productLabelList = json_decode($productLabelList, true);
        }

        if ($productLabelList === false) {
            /** @var \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory */
            $productLabelsCollection = $this->productLabelCollectionFactory->create();
            $productLabelList        = $productLabelsCollection
                ->addStoreFilter($storeId)
                ->addFieldToFilter('is_active', true)
                ->getData();

            $productLabelList        = array_map(function ($label) {
                $label['display_on'] = explode(',', $label['display_on']);

                return $label;
            }, $productLabelList);

            $this->cache->save(json_encode($productLabelList), $cacheKey, [\Smile\ProductLabel\Model\ProductLabel::CACHE_TAG]);
        }

        return $productLabelList;
    }

    /**
     * Get current store Id.
     */
    private function getStoreId(): int
    {
        return $this->storeManager->getStore()->getId();
    }
}
