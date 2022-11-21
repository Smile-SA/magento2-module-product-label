<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\FilterProcessor\CustomFilterInterface;
use Magento\Framework\Data\Collection\AbstractDb;

/**
 * Apply store filter on a product label collection.
 */
class ProductLabelStoreFilter implements CustomFilterInterface
{
    /**
     * @inheritdoc
     */
    public function apply(Filter $filter, AbstractDb $collection)
    {
        // @phpstan-ignore-next-line
        $collection->addStoreFilter($filter->getValue());
        return true;
    }
}
