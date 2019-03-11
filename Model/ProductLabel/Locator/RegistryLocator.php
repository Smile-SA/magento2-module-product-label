<?php
/**
 * Rule Registry Locator.
 * Used by Ui Component modifiers.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\ProductLabel\Model\ProductLabel\Locator;


class RegistryLocator implements LocatorInterface
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var null
     */
    private $productLabel = null;

    /**
     * RegistryLocator constructor.
     *
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(\Magento\Framework\Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function getProductLabel()
    {
        if (null !== $this->productLabel) {
            return $this->productLabel;
        }

        if ($productLabel = $this->registry->registry('current_productlabel')) {
            return $this->productLabel = $productLabel;
        }

        return null;
    }
}
