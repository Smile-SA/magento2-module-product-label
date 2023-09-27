<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Helper;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;
use Smile\ProductLabel\Api\ProductLabelRepositoryInterface;

/**
 * Product Label Data helper
 */
class Data extends AbstractHelper
{
    protected ProductLabelRepositoryInterface $productLabelRepository;
    protected FilterBuilder $filterBuilder;
    protected SortOrderBuilder $sortOrderBuilder;
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        Context $context,
        ProductLabelRepositoryInterface $productLabelRepository,
        FilterBuilder $filterBuilder,
        SortOrderBuilder $sortOrderBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->productLabelRepository      = $productLabelRepository;
        $this->filterBuilder         = $filterBuilder;
        $this->sortOrderBuilder      = $sortOrderBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;

        parent::__construct($context);
    }

    /**
     * Get product label ids
     *
     * @return int[]
     */
    public function getProductLabelIds(ProductInterface $product): array
    {
        /** @var Product $product */
        $productLabelIds = $product->getData('smile_product_label_ids');
        if (!is_array($productLabelIds)) {
            $productLabelIds = explode(',', (string) $productLabelIds);
        }

        foreach ($productLabelIds as $key => $value) {
            $productLabelIds[$key] = (int) $value;
        }

        return $productLabelIds;
    }

    /**
     * Get search criteria on product label ids
     *
     * @param int[] $productLabelIds Product Label ids
     */
    public function getSearchCriteriaOnProductLabelIds(array $productLabelIds): SearchCriteria
    {
        $filters   = [];
        $filters[] = $this->filterBuilder
            ->setField(ProductLabelInterface::PRODUCTLABEL_ID)
            ->setConditionType('in')
            ->setValue($productLabelIds)
            ->create();
        $this->searchCriteriaBuilder->addFilters($filters);

        $sort = $this->sortOrderBuilder
            ->setField(ProductLabelInterface::PRODUCTLABEL_NAME)
            ->setDirection(SortOrder::SORT_ASC)
            ->create();

        $this->searchCriteriaBuilder->addSortOrder($sort);

        return $this->searchCriteriaBuilder->create();
    }

    /**
     * Get product labels
     *
     * @return ProductLabelInterface[]
     */
    public function getProductLabels(ProductInterface $product): array
    {
        $productLabelIds = $this->getProductLabelIds($product);
        $searchCriteria = $this->getSearchCriteriaOnProductLabelIds($productLabelIds);

        /** @var ProductLabelInterface[] $items */
        $items =  $this->productLabelRepository->getList($searchCriteria)->getItems();
        return $items;
    }
}
