<?php
/**
 *
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */

namespace Smile\ProductLabel\Model\ResourceModel\Attribute\Grid;

use \Magento\Framework\Api\Search\SearchResultInterface;


class Collection extends \Smile\ProductLabel\Model\ResourceModel\Attribute\Collection implements SearchResultInterface
{
    /**
     * @var \Magento\Framework\Api\Search\AggregationInterface[]
     */
    private $aggregations;
    /**
     * {@inheritdoc}
     */
    public function setItems(array $items = null)
    {
        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }
    /**
     * {@inheritdoc}
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getSearchCriteria()
    {
        return null;
    }
    /**
     * {@inheritdoc}
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }
    /**
     * {@inheritdoc}
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }
    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     *
     * {@inheritDoc}
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setModel('Magento\Framework\View\Element\UiComponent\DataProvider\Document');
    }
    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     *
     * {@inheritdoc}
     */
    protected function _renderFiltersBefore()
    {
        parent::_renderFiltersBefore();
        $this->getSelect()->joinInner(
            ['ea' => $this->getTable('smile_product_label')],
            'ea.attribute_id = main_table.attribute_id',
            ['frontend_label']
        );

        return $this;
    }
}