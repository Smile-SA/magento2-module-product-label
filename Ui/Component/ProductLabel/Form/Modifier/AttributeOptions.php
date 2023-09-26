<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Ui\Component\ProductLabel\Form\Modifier;

use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Eav\Api\Data\AttributeInterface;
use Magento\Eav\Model\Entity\Attribute\AbstractAttribute;
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
    public function modifyData(array $data): array
    {
        return $data;
    }

    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta): array
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
     */
    private function getAttributeOptions(int $attributeId): array
    {
        /** @var string $attributeId */
        $attribute = $this->attributeRepository->get($attributeId);
        $options   = [];

        /** @var  AbstractAttribute $attribute */
        $source = $attribute->getSource();

        /** @var AttributeInterface $attribute */
        $attributeId = $attribute->getAttributeId();
        if ($attributeId) {
            $options = $source->getAllOptions();
        }

        return $options;
    }
}
