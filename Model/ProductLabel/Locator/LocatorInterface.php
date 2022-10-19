<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\ProductLabel\Locator;

use Smile\ProductLabel\Api\Data\ProductLabelInterface;

/**
 * Rule Locator interface
 */
interface LocatorInterface
{
    /**
     * Retrieve current product label.
     */
    public function getProductLabel(): ProductLabelInterface;
}
