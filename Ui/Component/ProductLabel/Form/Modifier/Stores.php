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
 * Smile Product Label edit form data provider modifier :
 *
 * Used to populate "store_id" field according to current value of "store_id" for current product label.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class Stores implements \Magento\Ui\DataProvider\Modifier\ModifierInterface
{
    /**
     * @var \Smile\ProductLabel\Model\ProductLabel\Locator\LocatorInterface
     */
    private $locator;

    /**
     * AttributeOptions constructor.
     *
     * @param \Smile\ProductLabel\Model\ProductLabel\Locator\LocatorInterface $locator Label Locatory
     */
    public function __construct(
        \Smile\ProductLabel\Model\ProductLabel\Locator\LocatorInterface $locator
    ) {
        $this->locator = $locator;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        $productLabel = $this->locator->getProductLabel();

        if ($productLabel
            && $productLabel->getId()
            && !empty($productLabel->getStores())
            && empty($data[$productLabel->getId()]['store_id'])
        ) {
            $data[$productLabel->getId()]['store_id'] = $productLabel->getStores();
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }
}
