<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Ui\Component\ProductLabel\Form\Modifier;

use Smile\ProductLabel\Api\Data\ProductLabelInterface;

/**
 * Smile Product Label edit form data provider modifier :
 * Used to set "attribute_id" field to disabled in case of already existing product label.
 */
class Attribute implements \Magento\Ui\DataProvider\Modifier\ModifierInterface
{
    private \Smile\ProductLabel\Model\ProductLabel\Locator\LocatorInterface $locator;

    /**
     * Attribute constructor.
     *
     * @param \Smile\ProductLabel\Model\ProductLabel\Locator\LocatorInterface $locator Label Locator
     */
    public function __construct(
        \Smile\ProductLabel\Model\ProductLabel\Locator\LocatorInterface $locator
    ) {
        $this->locator = $locator;
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data)
    {
        $productLabel = $this->locator->getProductLabel();

        // @codingStandardsIgnoreStart
        if ($productLabel->getId() && isset($data[$productLabel->getId()][ProductLabelInterface::ATTRIBUTE_ID])) {
            $data[$productLabel->getId()]['attribute_label'] = $data[$productLabel->getId()][ProductLabelInterface::ATTRIBUTE_ID];
        }
        // @codingStandardsIgnoreEnd

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta)
    {
        $productLabel = $this->locator->getProductLabel();

        $isNew = !$productLabel->getId();

        $meta['general']['children']['attribute_id']['arguments']['data']['config']['disabled'] = !$isNew;
        $meta['general']['children']['attribute_id']['arguments']['data']['config']['visible']  = $isNew;

        $meta['general']['children']['attribute_label']['arguments']['data']['config']['disabled'] = $isNew;
        $meta['general']['children']['attribute_label']['arguments']['data']['config']['visible']  = !$isNew;

        return $meta;
    }
}
