<?php

namespace Smile\ProductLabel\Model\ResourceModel\ProductLabel\Attributes;

/**
 * Product Label Attributes Collection
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class Collection extends \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection
{
    /**
     * @var array
     */
    private $defaultAvailableFrontendInputs = ['select', 'multiselect'];

    /**
     * @var array
     */
    private $availableFrontendInputs = [];

    /**
     * Collection constructor.
     *
     * @param \Magento\Framework\Data\Collection\EntityFactory             $entityFactory
     * @param \Psr\Log\LoggerInterface                                     $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface                    $eventManager
     * @param \Magento\Eav\Model\Config                                    $eavConfig
     * @param \Magento\Eav\Model\EntityFactory                             $eavEntityFactory
     * @param \Magento\Framework\DB\Adapter\AdapterInterface|null          $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null    $resource
     * @param array                                                        $availableFrontendInputs
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Eav\Model\EntityFactory $eavEntityFactory,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null,
        $availableFrontendInputs = []
    ) {
        $this->availableFrontendInputs = array_merge($this->defaultAvailableFrontendInputs, $availableFrontendInputs);

        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $eavConfig,
            $eavEntityFactory,
            $connection,
            $resource
        );
    }

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     *
     * {@inheritdoc}
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()->where($this->_getConditionSql('frontend_input', ['in' => $this->availableFrontendInputs]));

        return $this;
    }
}
