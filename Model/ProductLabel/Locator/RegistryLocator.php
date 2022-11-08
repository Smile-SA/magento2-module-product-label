<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\ProductLabel\Locator;

use Magento\Framework\Registry;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;

/**
 * Rule Registry Locator.
 * Used by Ui Component modifiers.
 */
class RegistryLocator implements LocatorInterface
{
    private Registry $registry;

    /**
     * @var null
     */
    private $productLabel = null;

    /**
     * RegistryLocator constructor.
     *
     * @param Registry $registry Registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @inheritdoc
     */
    public function getProductLabel(): ProductLabelInterface
    {
        $this->productLabel = $this->registry->registry('current_productlabel');
        return $this->productLabel;
    }
}
