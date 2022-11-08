<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\ResourceModel\ProductLabel\Grid;

use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\Collection as SmileProductLabelCollection;

/**
 * Product Label Grid Collection
 */
class Collection extends SmileProductLabelCollection implements SearchResultInterface
{
    /**
     * @var AggregationInterface
     */
    private $aggregations;

    /**
     * @inheritdoc
     */
    public function setItems(?array $items = null)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * @inheritdoc
     */
    public function setAggregations($aggregations): AggregationInterface
    {
        $this->aggregations = $aggregations;
        return $this->aggregations;
    }

    /**
     * @inheritdoc
     */
    public function getSearchCriteria()
    {
        // @phpstan-ignore-next-line
        return null;
    }

    /**
     * @inheritdoc
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * @inheritdoc
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * Construct.
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     * @inheritdoc
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setModel(Document::class);
    }

    /**
     * Render filters before
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     * @inheritdoc
     */
    protected function _renderFiltersBefore()
    {
        parent::_renderFiltersBefore();

        $this->getSelect()->joinInner(
            ['ea' => $this->getTable('eav_attribute')],
            'ea.attribute_id = main_table.attribute_id',
            ['frontend_label']
        );

        $this->getSelect()->joinLeft(
            ['eaov' => $this->getTable('eav_attribute_option_value')],
            'eaov.option_id = main_table.option_id',
            ['option_label' => 'value']
        );

        $storeCondition = \Magento\Store\Model\Store::DEFAULT_STORE_ID;

        if ($this->getFilter('store')) {
            $storeId = current($this->getStoreIds());

            $this->getSelect()->joinLeft(
                ['eaov_s' => $this->getTable('eav_attribute_option_value')],
                sprintf('eaov_s.option_id = main_table.option_id AND eaov_s.store_id = %s', $storeId),
                ['option_label' => 'value']
            );

            $storeCondition = $this->getConnection()->getIfNullSql(
                "eaov_s.store_id",
                \Magento\Store\Model\Store::DEFAULT_STORE_ID
            );
        }

        $this->getSelect()->where('eaov.store_id = ?', $storeCondition);
    }
}
