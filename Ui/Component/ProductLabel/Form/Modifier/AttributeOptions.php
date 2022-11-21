<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Ui\Component\ProductLabel\Form\Modifier;

use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Smile\ProductLabel\Model\ProductLabel\Locator\LocatorInterface;

/**
 * Class AttributeOptions
 * Smile Product Label edit form data provider modifier :
 *
 * Used to populate "option_id" field according to current value of "attribute_id" for current product label.
 */
class AttributeOptions implements ModifierInterface
{
    private LocatorInterface $locator;

    private ProductAttributeRepositoryInterface $attributeRepository;

    /**
     * AttributeOptions constructor.
     *
     * @param LocatorInterface $locator             Label Locatory
     * @param ProductAttributeRepositoryInterface        $attributeRepository Attribute Repository
     */
    public function __construct(
        LocatorInterface $locator,
        ProductAttributeRepositoryInterface $attributeRepository
    ) {
        $this->locator             = $locator;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta)
    {
        $productLabel = $this->locator->getProductLabel();

        $options = [];
        if ($productLabel->getAttributeId()) {
            $options = $this->getAttributeOptions($productLabel->getAttributeId());
        }

        $meta['general']['children']['option_id']['arguments']['data']['options']    = $options;
        $meta['general']['children']['option_label']['arguments']['data']['options'] = $options;

        $isNew = !$productLabel->getId();
        $optionFieldVisible = $isNew && $productLabel->getAttributeId();

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
     * @return array
     */
    private function getAttributeOptions(int $attributeId): array
    {
        /** @var string $attributeId */
        $attribute = $this->attributeRepository->get($attributeId);
        $options   = [];

        /** @var  \Magento\Eav\Model\Entity\Attribute\AbstractAttribute $attribute */
        $source = $attribute->getSource();

        /** @var \Magento\Eav\Api\Data\AttributeInterface $attribute */
        $attributeId = $attribute->getAttributeId();

        if ($attributeId) {
            $options = $source->getAllOptions();
        }

        return $options;
    }
}
