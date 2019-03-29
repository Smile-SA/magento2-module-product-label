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
 * Class ProductLabel
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
     * Config constructor.
     *
     * @param \Magento\Framework\App\Cache\StateInterface        $cacheState
     * @param \Magento\Framework\Validator\UniversalFactory      $universalFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Catalog\Model\ResourceModel\ConfigFactory $configFactory
     * @param \Magento\Store\Model\StoreManagerInterface         $storeManager
     * @param \Magento\Eav\Model\Config                          $eavConfig
     */
    public function __construct(
        \Magento\Framework\App\Cache\StateInterface $cacheState,
        \Magento\Framework\Validator\UniversalFactory $universalFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Model\ResourceModel\ConfigFactory $configFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_configFactory = $configFactory;
        $this->_storeManager = $storeManager;
        $this->_eavConfig = $eavConfig;
        $this->_attributeFactory = $attributeFactory;
    }

    /**
     * Retrieve Attributes used in product listing
     *
     * @return array
     */
    public function afterGetAttributesUsedInProductListing()
    {
        if ($this->_usedInProductListing === null) {
            $this->_usedInProductListing = [];
            $entityType = \Magento\Catalog\Model\Product::ENTITY;

            $attributesData = $this->_getResource()->setStoreId($this->getStoreId())->getAttributesUsedInListing();
            $this->_eavConfig->importAttributesData($entityType, $attributesData);
            foreach ($attributesData as $attributeData) {
                $attributeCode = $attributeData['attribute_code'];
                $this->_usedInProductListing[$attributeCode] = $this->_eavConfig->getAttribute(
                    $entityType,
                    $attributeCode
                );
            }

            $attributesDataExtra = $this->_attributeFactory->getCollection()->getData();
            $this->_eavConfig->importAttributesData($entityType, $attributesDataExtra);
            foreach ($attributesDataExtra as $attributeData) {
                if ($attributeData['backend_model'] == \Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend::class) {
                    $attributeCode = $attributeData['attribute_code'];
                    $this->_usedInProductListing[$attributeCode] = $this->_eavConfig->getAttribute(
                        $entityType,
                        $attributeCode
                    );
                }
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