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

namespace Smile\ProductLabel\Model\ProductLabel\Locator;

/**
 * Rule Registry Locator.
 * Used by Ui Component modifiers.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
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
     * @param \Magento\Framework\Registry $registry Registry
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
