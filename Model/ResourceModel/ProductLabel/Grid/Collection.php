<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\ResourceModel\ProductLabel\Grid;

use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Magento\Store\Model\Store;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\Collection as SmileProductLabelCollection;

/**
 * Product Label Grid Collection
 */
class Collection extends SmileProductLabelCollection implements SearchResultInterface
{
    private AggregationInterface $aggregations;

    /**
     * @inheritdoc
     */
    public function setItems(?array $items = null): self
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAggregations(): AggregationInterface
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
    public function getSearchCriteria(): ?SearchCriteriaInterface
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria): self
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTotalCount(): int
    {
        return $this->getSize();
    }

    /**
     * @inheritdoc
     */
    public function setTotalCount($totalCount): self
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setModel(Document::class);
    }

    /**
     * @inheritdoc
     */
    protected function _renderFiltersBefore()
    {
        parent::_renderFiltersBefore();
        $storeCondition = Store::DEFAULT_STORE_ID;

        $this->getSelect()->joinInner(
            ['ea' => $this->getTable('eav_attribute')],
            'ea.attribute_id = main_table.attribute_id',
            ['frontend_label']
        );

        $this->getSelect()->joinLeft(
            ['eao' => $this->getTable('eav_attribute_option')],
            'eao.option_id = main_table.option_id and ea.attribute_id = eao.attribute_id',
            []
        );

        $this->getSelect()->joinLeft(
            ['eaov' => $this->getTable('eav_attribute_option_value')],
            sprintf('eaov.option_id = eao.option_id and eaov.store_id = %s', $storeCondition),
            ['option_label' => $this->getConnection()->getIfNullSql('eaov.value', 'main_table.option_id')]
        );

        if ($this->getFilter('store')) {
            $storeId = current($this->getStoreIds());

            $this->getSelect()->joinLeft(
                ['eaov_s' => $this->getTable('eav_attribute_option_value')],
                sprintf('eaov_s.option_id = eao.option_id AND eaov_s.store_id = %s', $storeId),
                [
                    'option_label' =>
                        $this->getConnection()->getIfNullSql(
                            'eaov_s.value',
                            (string) $this->getConnection()->getIfNullSql('eaov.value', 'main_table.option_id')
                        ),
                ]
            );
        }
    }
}
