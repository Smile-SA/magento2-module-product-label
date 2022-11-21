<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Ui\Component\Source\Attribute;

use Magento\Framework\Data\OptionSourceInterface;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\Attributes\CollectionFactory;

/**
 * Attributes options values for virtual attribute product label edit form.
 */
class Options implements OptionSourceInterface
{
    private CollectionFactory $attributesCollectionFactory;

    /**
     * @var array|null
     */
    private ?array $attributesList = null;

    /**
     * Options constructor.
     *
     * @param CollectionFactory $attributesCollectionFactory Attributes Collection Factory
     */
    public function __construct(CollectionFactory $attributesCollectionFactory)
    {
        $this->attributesCollectionFactory = $attributesCollectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        return $this->getAttributesList();
    }

    /**
     * Retrieve list of attributes that can be used to define product labels.
     *
     * @return array
     */
    private function getAttributesList(): array
    {
        if (null === $this->attributesList) {
            $this->attributesList = [];

            $collection = $this->attributesCollectionFactory->create();

            foreach ($collection as $attribute) {
                $this->attributesList[$attribute->getId()] = [
                    'value' => $attribute->getId(),
                    'label' => $attribute->getFrontendLabel(),
                ];
            }
        }

        return $this->attributesList;
    }
}
