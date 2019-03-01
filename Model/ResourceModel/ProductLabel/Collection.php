<?php
namespace Smile\ProductLabel\Model\ResourceModel\ProductLabel;

use Smile\ProductLabel\Api\Data\ProductLabelInterface;

/**
 * Product Label Collection
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = ProductLabelInterface::PRODUCTLABEL_ID;
    /**
     * @var int[]
     */
    private $storeIds = [];
    /**
     * Get store ids applied to current collection.
     *
     * @return int[]
     */
    public function getStoreIds()
    {
        return $this->storeIds;
    }
    /**
     * Retrieve all distinct attribute ids of current collection.
     *
     * @return array
     */
    public function getAllAttributeIds()
    {
        $optionIdsSelect = clone $this->getSelect();
        $optionIdsSelect->reset(\Magento\Framework\DB\Select::ORDER);
        $optionIdsSelect->reset(\Magento\Framework\DB\Select::LIMIT_COUNT);
        $optionIdsSelect->reset(\Magento\Framework\DB\Select::LIMIT_OFFSET);
        $optionIdsSelect->reset(\Magento\Framework\DB\Select::COLUMNS);
        $optionIdsSelect->distinct(true)->columns(ProductLabelInterface::ATTRIBUTE_ID, 'main_table');
        return $this->getConnection()->fetchCol($optionIdsSelect, $this->_bindParams);
    }
    /**
     * Retrieve all distinct options ids of current collection.
     *
     * @return array
     */
    public function getAllOptionIds()
    {
        $optionIdsSelect = clone $this->getSelect();
        $optionIdsSelect->reset(\Magento\Framework\DB\Select::ORDER);
        $optionIdsSelect->reset(\Magento\Framework\DB\Select::LIMIT_COUNT);
        $optionIdsSelect->reset(\Magento\Framework\DB\Select::LIMIT_OFFSET);
        $optionIdsSelect->reset(\Magento\Framework\DB\Select::COLUMNS);
        $optionIdsSelect->distinct(true)->columns(ProductLabelInterface::OPTION_ID, 'main_table');
        return $this->getConnection()->fetchCol($optionIdsSelect, $this->_bindParams);
    }
    /**
     * Filter productlabel collection for a given attribute.
     *
     * @param \Magento\Catalog\Api\Data\ProductAttributeInterface $attribute The attribute
     *
     * @return $this
     */
    public function addAttributeFilter(\Magento\Catalog\Api\Data\ProductAttributeInterface $attribute)
    {
        if ($attribute->getAttributeId()) {
            $this->addFieldToFilter(ProductLabelInterface::ATTRIBUTE_ID, (int) $attribute->getAttributeId());
        }
        return $this;
    }
    /**
     * Filter productlabel collection for a given list of attribute set ids.
     *
     * @param array $attributeSetIds List of attribute set ids
     *
     * @return $this
     */
    public function addAttributeSetIdFilter($attributeSetIds)
    {
        if (!is_array($attributeSetIds)) {
            $attributeSetIds = [$attributeSetIds];
        }
        $this->getSelect()->joinInner(
            ['ea' => $this->getTable('eav_attribute')],
            'ea.attribute_id = main_table.attribute_id'
        )->where('ea.attribute_set_id IN (?)', $attributeSetIds);
        $this->getSelect()->group(ProductLabelInterface::PRODUCTLABEL_ID);
        return $this;
    }
    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(
            'Smile\ProductLabel\Model\ProductLabel',
            'Smile\ProductLabel\Model\ResourceModel\ProductLabel'
        );
        /* @see self::_renderFiltersBefore() */
        $this->_map['fields']['attribute_id'] = 'main_table.attribute_id';
    }

}