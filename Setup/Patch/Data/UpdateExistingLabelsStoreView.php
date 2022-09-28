<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\Store;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;

/**
 * Populate Label/Store link table with default store view for all existing labels.
 */
class UpdateExistingLabelsStoreView implements DataPatchInterface
{
    private \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup Module Data Setup
     */
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $connection = $this->moduleDataSetup->getConnection();
        $select     = $connection->select()->from(
            ProductLabelInterface::TABLE_NAME,
            [
                ProductLabelInterface::PRODUCTLABEL_ID => ProductLabelInterface::PRODUCTLABEL_ID,
                new \Zend_Db_Expr(Store::DEFAULT_STORE_ID . ' as ' . ProductLabelInterface::STORE_ID),
            ]
        );

        $data = $connection->fetchAll($select);
        $connection->insertOnDuplicate(
            ProductLabelInterface::STORE_TABLE_NAME,
            $data,
            [ProductLabelInterface::PRODUCTLABEL_ID, ProductLabelInterface::STORE_ID]
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}
