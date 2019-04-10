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
    protected $_usedInProductListing;

    /**
     * Eav config
     *
     * @var \Magento\Eav\Model\Config
     */
    protected $_eavConfig;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Eav\Attribute
     */
    protected $_attributeFactory;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var int|float|string|null
     */
    protected $_storeId = null;

    /**
     * @var \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Config constructor.
     *
     * @param \Magento\Framework\App\Cache\StateInterface                            $cacheState
     * @param \Magento\Framework\Validator\UniversalFactory                          $universalFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface                     $scopeConfig
     * @param \Magento\Catalog\Model\ResourceModel\ConfigFactory                     $configFactory
     * @param \Magento\Store\Model\StoreManagerInterface                             $storeManager
     * @param \Magento\Eav\Model\Config                                              $eavConfig
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute                     $attributeFactory
     * @param \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory $productLabelCollectionFactory
     */
    public function __construct(
        \Magento\Framework\App\Cache\StateInterface $cacheState,
        \Magento\Framework\Validator\UniversalFactory $universalFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Model\ResourceModel\ConfigFactory $configFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory,
        \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory $productLabelCollectionFactory
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_configFactory = $configFactory;
        $this->_storeManager = $storeManager;
        $this->_eavConfig = $eavConfig;
        $this->_attributeFactory = $attributeFactory;
        $this->productLabelCollectionFactory = $productLabelCollectionFactory;
    }

    /**
     * Retrieve Attributes used in product listing
     *
     * @return array
     */
    public function afterGetAttributesUsedInProductListing(\Magento\Catalog\Model\Config $subject, $result)
    {
        if ($this->_usedInProductListing === null) {
            $this->_usedInProductListing = $result;
            $entityType = \Magento\Catalog\Model\Product::ENTITY;

            /** @var \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory */
            $productLabelsCollection = $this->productLabelCollectionFactory->create();
            // Here you have all the attribute ids that are used to build product label rules.
            $attributeIds = $productLabelsCollection->getAllAttributeIds();

            // Filter the collection on these attributes only.
            $attributesDataExtra = $this->_attributeFactory->getCollection()->addFieldToFilter('attribute_id', ['in' => $attributeIds])->getData();
            $this->_eavConfig->importAttributesData($entityType, $attributesDataExtra);
            foreach ($attributesDataExtra as $attributeData) {
                $attributeCode = $attributeData['attribute_code'];
                $this->_usedInProductListing[$attributeCode] = $this->_eavConfig->getAttribute(
                    $entityType,
                    $attributeCode
                );
            }
        }

        return $this->_usedInProductListing;
    }

    /**
     * Retrieve resource model
     *
     * @return \Magento\Catalog\Model\ResourceModel\Config
     */
    protected function _getResource()
    {
        return $this->_configFactory->create();
    }

    /**
     * Return store id, if is not set return current app store
     *
     * @return integer
     */
    public function getStoreId()
    {
        if ($this->_storeId === null) {
            return $this->_storeManager->getStore()->getId();
        }
        return $this->_storeId;
    }

}
