<?php

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
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class Data extends AbstractHelper
{
    /**
     * @var ProductLabelRepositoryInterface
     */
    protected $plabelRepository;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * Data constructor.
     * @param Context $context
     * @param ProductLabelRepositoryInterface $plabelRepository
     * @param FilterBuilder $filterBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        Context $context,
        ProductLabelRepositoryInterface $plabelRepository,
        FilterBuilder $filterBuilder,
        SortOrderBuilder $sortOrderBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder
        )
    {
        $this->plabelRepository = $plabelRepository;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;

        parent::__construct($context);
    }

    /**
     * @param ProductInterface $product
     * @return int[]
     */
    public function getProductLabelIds(ProductInterface $product)
    {
        $plabelIds = $product->getSmileProductLabelIds();
        if (!is_array($plabelIds)) {
            $plabelIds = explode(',', $plabelIds);
        }

        foreach ($plabelIds as $key => $value) {
            $plabelIds[$key] = (int) $value;
        }

        return $plabelIds;
    }

    /**
     * @param int[] $plabelIds
     * @return SearchCriteria
     */
    public function getSearchCriteriaOnProductLabelIds($plabelIds)
    {

        $filters = [];
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
     * @param ProductInterface $product
     * @return ProductLabelInterface[]
     */
    public function getProductLabels(ProductInterface $product)
    {
        $plabelIds = $this->getProductLabelIds($product);
        $searchCriteria = $this->getSearchCriteriaOnProductLabelIds($plabelIds);

        return $this->plabelRepository->getList($searchCriteria)->getItems();
    }

}
