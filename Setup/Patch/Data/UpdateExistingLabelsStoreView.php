<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\Store;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;
use Zend_Db_Expr;

/**
 * Populate Label/Store link table with default store view for all existing labels.
 */
class UpdateExistingLabelsStoreView implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @inheritdoc
     */
    public function apply(): self
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $connection = $this->moduleDataSetup->getConnection();
        $select     = $connection->select()->from(
            $connection->getTableName(ProductLabelInterface::TABLE_NAME),
            [
                ProductLabelInterface::PRODUCTLABEL_ID => ProductLabelInterface::PRODUCTLABEL_ID,
                new Zend_Db_Expr(Store::DEFAULT_STORE_ID . ' as ' . ProductLabelInterface::STORE_ID),
            ]
        );

        $data = $connection->fetchAll($select);
        $connection->insertOnDuplicate(
            $connection->getTableName(ProductLabelInterface::STORE_TABLE_NAME),
            $data,
            [ProductLabelInterface::PRODUCTLABEL_ID, ProductLabelInterface::STORE_ID]
        );

        $this->moduleDataSetup->getConnection()->endSetup();

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases(): array
    {
        return [];
    }
}
