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

namespace Smile\ProductLabel\Ui\Component\ProductLabel\Form\Modifier;

/**
 * Class AttributeOptions
 * Smile Product Label edit form data provider modifier :
 *
 * Used to populate "option_id" field according to current value of "attribute_id" for current product label.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class AttributeOptions implements \Magento\Ui\DataProvider\Modifier\ModifierInterface
{
    /**
     * @var \Smile\ProductLabel\Model\ProductLabel\Locator\LocatorInterface
     */
    private $locator;

    /**
     * @var \Magento\Catalog\Api\ProductAttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * AttributeOptions constructor.
     *
     * @param \Smile\ProductLabel\Model\ProductLabel\Locator\LocatorInterface $locator             Label Locatory
     * @param \Magento\Catalog\Api\ProductAttributeRepositoryInterface        $attributeRepository Attribute Repository
     */
    public function __construct(
        \Smile\ProductLabel\Model\ProductLabel\Locator\LocatorInterface $locator,
        \Magento\Catalog\Api\ProductAttributeRepositoryInterface $attributeRepository
    ) {
        $this->locator             = $locator;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        $productLabel = $this->locator->getProductLabel();

        $options = [];
        if ($productLabel && $productLabel->getAttributeId()) {
            $options = $this->getAttributeOptions((int) $productLabel->getAttributeId());
        }

        $meta['general']['children']['option_id']['arguments']['data']['options']    = $options;
        $meta['general']['children']['option_label']['arguments']['data']['options'] = $options;

        $isNew          = (!$productLabel || !$productLabel->getId());
        $optionFieldVisible = $isNew && $productLabel && $productLabel->getAttributeId();

        $meta['general']['children']['option_id']['arguments']['data']['config']['disabled'] = !$isNew;
        $meta['general']['children']['option_id']['arguments']['data']['config']['visible']  = $optionFieldVisible;

        $meta['general']['children']['option_label']['arguments']['data']['config']['disabled'] = $isNew;
        $meta['general']['children']['option_label']['arguments']['data']['config']['visible']  = !$isNew;

        return $meta;
    }

    /**
     * Retrieve attribute options for a given attribute Id.
     *
     * @param int $attributeId The attribute Id
     *
     * @return array
     */
    private function getAttributeOptions($attributeId)
    {
        $attribute = $this->attributeRepository->get($attributeId);
        $options   = [];

        if ($attribute && $attribute->getAttributeId() && $attribute->getSource()) {
            $options = $attribute->getSource()->getAllOptions(false);
        }

        return $options;
    }
}
