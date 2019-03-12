<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Smile\ProductLabel\Option\ProductLabel as ProductLabelOption;

/**
 * Class CreateProductAttribute
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CreateProductAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavConfig
     */
    private $eavConfig;

    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavConfig $eavConfig
     * @param CustomerSetupFactory $customerSetupFactory
     * @param EavSetupFactory $eavSetupFactory
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavConfig $eavConfig,
        CustomerSetupFactory $customerSetupFactory,
        EavSetupFactory $eavSetupFactory,
        AttributeRepositoryInterface $attributeRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavConfig = $eavConfig;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * Get array of patches that have to be executed prior to this.
     *
     * example of implementation:
     *
     * [
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch1::class,
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch2::class
     * ]
     *
     * @return string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Run code inside patch
     * If code fails, patch must be reverted, in case when we are speaking about schema - than under revert
     * means run PatchInterface::revert()
     *
     * If we speak about data, under revert means: $transaction->rollback()
     *
     * @return $this
     */
    public function apply()
    {
        /**
         * @var $eavSetup EavSetup
         */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(
            Product::ENTITY,
            'smile_productlabel_ids',
            [
                'label' => 'Smile Product Label',
                'type' => 'text',
                'input' => 'multiselect',
                'backend' => ArrayBackend::class,
                'frontend' => '',
                'class' => '',
                'source' => ProductLabelOption::class,
                'global' => Attribute::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => true,
                'visible_on_front' => true,
                'used_in_product_listing' => false,
                'is_html_allowed_on_front' => true,
                'unique' => false,
                'apply_to' => 'simple,configurable',
            ]
        );

        $eavSetup->addAttributeGroup(
            Product::ENTITY,
            'default',
            'Smile'
        );

        $eavSetup->addAttributeToGroup(
            Product::ENTITY,
            'default',
            'Smile',
            'smile_productlabel_ids'
        );

        $this->eavConfig->clear();
    }
}