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
namespace Smile\ProductLabel\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor;

/**
 * Apply store filter on a product label collection.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class ProductLabelStoreFilter implements \Magento\Framework\Api\SearchCriteria\CollectionProcessor\FilterProcessor\CustomFilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function apply(\Magento\Framework\Api\Filter $filter, \Magento\Framework\Data\Collection\AbstractDb $collection)
    {
        /** @var \Smile\ProductLabel\Model\ResourceModel\ProductLabel\Collection $collection */
        $collection->addStoreFilter($filter->getValue());

        return true;
    }
}
