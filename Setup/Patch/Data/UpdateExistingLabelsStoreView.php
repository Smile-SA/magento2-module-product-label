<?php
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Romain Ruaud <romain.ruaud@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;

/**
 * Populate Label/Store link table with default store view for all existing labels.
 *
 * @category Smile
 * @package  Smile\ProductLabel
 * @author   Romain Ruaud <romain.ruaud@smile.fr>
 */
class UpdateExistingLabelsStoreView implements DataPatchInterface
{
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup Module Data Setup
     */
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $connection = $this->moduleDataSetup->getConnection();
        $select     = $connection->select()->from(
            ProductLabelInterface::TABLE_NAME,
            [
                ProductLabelInterface::PRODUCTLABEL_ID => ProductLabelInterface::PRODUCTLABEL_ID,
                new \Zend_Db_Expr(\Magento\Store\Model\Store::DEFAULT_STORE_ID . ' as ' . ProductLabelInterface::STORE_ID),
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
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
