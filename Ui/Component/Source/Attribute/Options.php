<?php
namespace Smile\ProductLabel\Ui\Component\Source\Attribute;

use \Smile\ProductLabel\Model\ResourceModel\ProductLabel\Attributes\CollectionFactory;

/**
 * Attributes options values for virtual attribute product label edit form.
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
    private $attributesList;

    /**
     * Options constructor.
     *
     * @param CollectionFactory $attributesCollectionFactory
     */
    public function __construct(CollectionFactory $attributesCollectionFactory)
    {
        $this->attributesCollectionFactory = $attributesCollectionFactory;
    }

    /**
     * {@inheritdoc}
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
    private function getAttributesList()
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
