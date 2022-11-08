<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Helper;

use Magento\Catalog\Api\Data\ProductInterface;
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
    protected ProductLabelRepositoryInterface $plabelRepository;

    protected FilterBuilder $filterBuilder;

    protected SortOrderBuilder $sortOrderBuilder;

    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * Data constructor.
     *
     * @param Context                         $context               Context
     * @param ProductLabelRepositoryInterface $plabelRepository      Product Label Repository
     * @param FilterBuilder                   $filterBuilder         Filter Builder
     * @param SortOrderBuilder                $sortOrderBuilder      Sort Order Builder
     * @param SearchCriteriaBuilder           $searchCriteriaBuilder Search Criteria Builder
     */
    public function __construct(
        Context $context,
        ProductLabelRepositoryInterface $plabelRepository,
        FilterBuilder $filterBuilder,
        SortOrderBuilder $sortOrderBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->plabelRepository      = $plabelRepository;
        $this->filterBuilder         = $filterBuilder;
        $this->sortOrderBuilder      = $sortOrderBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;

        parent::__construct($context);
    }

    /**
     * Get product label ids
     *
     * @param ProductInterface $product The product
     * @return int[]
     */
    public function getProductLabelIds(ProductInterface $product): array
    {
        // @phpstan-ignore-next-line
        $plabelIds = $product->getSmileProductLabelIds();
        if (!is_array($plabelIds)) {
            $plabelIds = explode(',', (string) $plabelIds);
        }

        foreach ($plabelIds as $key => $value) {
            $plabelIds[$key] = (int) $value;
        }

        return $plabelIds;
    }

    /**
     * Get search criteria on product label ids
     *
     * @param int[] $plabelIds Product Label ids
     */
    public function getSearchCriteriaOnProductLabelIds(array $plabelIds): SearchCriteria
    {
        $filters   = [];
        $filters[] = $this->filterBuilder
            ->setField(ProductLabelInterface::PRODUCTLABEL_ID)
            ->setConditionType('in')
            ->setValue($plabelIds)
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
     * @param ProductInterface $product The Product
     * @return ProductLabelInterface[]
     */
    public function getProductLabels(ProductInterface $product): array
    {
        $plabelIds = $this->getProductLabelIds($product);
        $searchCriteria = $this->getSearchCriteriaOnProductLabelIds($plabelIds);

        return $this->plabelRepository->getList($searchCriteria)->getItems();
    }
}
