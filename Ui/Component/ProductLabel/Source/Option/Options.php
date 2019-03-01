<?php

namespace Smile\ProductLabel\Ui\Component\ProductLabel\Source\Option;

use Magento\Catalog\Model\Product\Attribute\Repository;
use \Smile\ProductLabel\Model\ResourceModel\ProductLabel\Attributes\CollectionFactory;

/**
 * Options values for attribute selected in edit form.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class Options implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Smile\ProductLabel\Model\ResourceModel\ProductLabel\Attributes\CollectionFactory
     */
    private $attributesCollectionFactory;
    /**
     * @var array|null
     */
    private $optionsList;
    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Repository
     */
    private $productAttributeRepository;
    /**
     * Options constructor.
     *
     * @param Repository        $productAttributeRepository
     * @param CollectionFactory $attributesCollectionFactory
     */
    public function __construct(
        Repository $productAttributeRepository,
        CollectionFactory $attributesCollectionFactory
    ) {
        $this->attributesCollectionFactory = $attributesCollectionFactory;
        $this->productAttributeRepository = $productAttributeRepository;
    }
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->getOptionsList();
    }
    /**
     * Retrieve list of options that can be used to define virtual options rules.
     *
     * @return array
     */
    private function getOptionsList()
    {
        if (null === $this->optionsList) {
            $this->optionsList = [];
            $collection = $this->attributesCollectionFactory->create();
            foreach ($collection as $attribute) {
                if (!empty($attribute->getAttributeCode())) {
                    $options = $this->productAttributeRepository->get($attribute->getAttributeCode())->getOptions();
                    foreach ($options as $option) {
                        $this->optionsList[$attribute->getAttributeId()] = [
                            'value'         => $option->getValue(),
                            'label'         => $option->getLabel(),
                            'attribute_id'  => $attribute->getAttributeId()
                        ];
                    }
                }
            }
        }
        return $this->optionsList;
    }
}