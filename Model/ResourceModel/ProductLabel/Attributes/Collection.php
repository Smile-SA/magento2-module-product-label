<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\ResourceModel\ProductLabel\Attributes;

use Magento\Eav\Model\Config;
use Magento\Eav\Model\EntityFactory as EavEntityFactory;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactory;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Psr\Log\LoggerInterface;

/**
 * Product Label Attributes Collection
 */
class Collection extends \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection
{
    /**
     * @var array
     */
    private array $defaultAvailableFrontendInputs = ['select', 'multiselect'];

    /**
     * @var array
     */
    private array $availableFrontendInputs = [];

    /**
     * Collection constructor.
     *
     * @param EntityFactory $entityFactory Entity Factory
     * @param LoggerInterface $logger Logger Interface
     * @param FetchStrategyInterface $fetchStrategy Fetch Strategy Interface
     * @param ManagerInterface $eventManager Event Manager Interface
     * @param Config $eavConfig EAV Config
     * @param EavEntityFactory $eavEntityFactory EAV Entity Factory
     * @param AdapterInterface|null $connection Adapter Interface
     * @param AbstractDb|null $resource Resource Model
     * @param array $availableFrontendInputs Array of Available Frontend Inputs
     */
    public function __construct(
        EntityFactory          $entityFactory,
        LoggerInterface        $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface       $eventManager,
        Config                 $eavConfig,
        EavEntityFactory       $eavEntityFactory,
        ?AdapterInterface      $connection = null,
        ?AbstractDb            $resource = null,
        array                  $availableFrontendInputs = []
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
     * Init select
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     * @inheritdoc
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()->where($this->_getConditionSql('frontend_input', ['in' => $this->availableFrontendInputs]));

        return $this;
    }
}
