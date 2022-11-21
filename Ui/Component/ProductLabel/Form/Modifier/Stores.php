<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Ui\Component\ProductLabel\Form\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Smile\ProductLabel\Model\ProductLabel\Locator\LocatorInterface;

/**
 * Smile Product Label edit form data provider modifier :
 *
 * Used to populate "store_id" field according to current value of "store_id" for current product label.
 */
class Stores implements ModifierInterface
{
    private LocatorInterface $locator;

    /**
     * AttributeOptions constructor.
     *
     * @param LocatorInterface $locator Label Locatory
     */
    public function __construct(
        LocatorInterface $locator
    ) {
        $this->locator = $locator;
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data)
    {
        $productLabel = $this->locator->getProductLabel();

        if (
            $productLabel->getId()
            && !empty($productLabel->getStores())
            && empty($data[$productLabel->getId()]['store_id'])
        ) {
            $data[$productLabel->getId()]['store_id'] = $productLabel->getStores();
        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }
}
