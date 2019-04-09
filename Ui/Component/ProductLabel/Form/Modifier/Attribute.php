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

use Smile\ProductLabel\Api\Data\ProductLabelInterface;

/**
 * Smile Product Label edit form data provider modifier :
 *
 * Used to set "attribute_id" field to disabled in case of already existing product label.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class Attribute implements \Magento\Ui\DataProvider\Modifier\ModifierInterface
{
    /**
     * @var \Smile\ProductLabel\Model\ProductLabel\Locator\LocatorInterface
     */
    private $locator;

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
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        $productLabel = $this->locator->getProductLabel();

        // @codingStandardsIgnoreStart
        if ($productLabel && $productLabel->getId() && isset($data[$productLabel->getId()][ProductLabelInterface::ATTRIBUTE_ID])) {
            $data[$productLabel->getId()]['attribute_label'] = $data[$productLabel->getId()][ProductLabelInterface::ATTRIBUTE_ID];
        }
        // @codingStandardsIgnoreEnd

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        $productLabel = $this->locator->getProductLabel();

        $isNew = (!$productLabel || !$productLabel->getId());

        $meta['general']['children']['attribute_id']['arguments']['data']['config']['disabled'] = !$isNew;
        $meta['general']['children']['attribute_id']['arguments']['data']['config']['visible']  = $isNew;

        $meta['general']['children']['attribute_label']['arguments']['data']['config']['disabled'] = $isNew;
        $meta['general']['children']['attribute_label']['arguments']['data']['config']['visible']  = !$isNew;

        return $meta;
    }
}
