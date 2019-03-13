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
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
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
     * @param ProductInterface $product The product
     *
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
     * @param int[] $plabelIds Product Label ids
     *
     * @return SearchCriteria
     */
    public function getSearchCriteriaOnProductLabelIds($plabelIds)
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
     * @param ProductInterface $product The Product
     *
     * @return ProductLabelInterface[]
     */
    public function getProductPLabels(ProductInterface $product)
    {
        $plabelIds      = $this->getProductLabelIds($product);
        $searchCriteria = $this->getSearchCriteriaOnProductLabelIds($plabelIds);

        return $this->plabelRepository->getList($searchCriteria)->getItems();
    }
}
