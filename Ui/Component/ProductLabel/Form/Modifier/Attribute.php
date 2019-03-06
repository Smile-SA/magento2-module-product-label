<?php
/**
 * Smile Elastic Suite Virtual Attribute rule edit form data provider modifier :
 *
 * Used to set "attribute_id" field to disabled in case of already existing rule.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\ProductLabel\Ui\Component\ProductLabel\Form\Modifier;

use Smile\ProductLabel\Api\Data\ProductLabelInterface;

class Attribute implements \Magento\Ui\DataProvider\Modifier\ModifierInterface
{
    /**
     * @var \Smile\ProductLabel\Model\ProductLabel\Locator\LocatorInterface
     */
    private $locator;

    /**
     * AttributeOptions constructor.
     *
     * @param \Smile\ProductLabel\Model\ProductLabel\Locator\LocatorInterface $locator Rule Locator
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

        if ($productLabel && $productLabel->getIdentifier() && isset($data[$productLabel->getIdentifier()][ProductLabelInterface::ATTRIBUTE_ID])) {
            $data[$productLabel->getIdentifier()]['attribute_label'] = $data[$productLabel->getIdentifier()][ProductLabelInterface::ATTRIBUTE_ID];
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        $productLabel = $this->locator->getProductLabel();

        $isNew = (!$productLabel || !$productLabel->getIdentifier());

        $meta['general']['children']['attribute_id']['arguments']['data']['config']['disabled'] = !$isNew;
        $meta['general']['children']['attribute_id']['arguments']['data']['config']['visible']  = $isNew;

        $meta['general']['children']['attribute_label']['arguments']['data']['config']['disabled'] = $isNew;
        $meta['general']['children']['attribute_label']['arguments']['data']['config']['visible']  = !$isNew;

        return $meta;
    }
}
