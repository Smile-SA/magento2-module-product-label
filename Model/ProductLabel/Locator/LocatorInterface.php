<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\ProductLabel\Locator;

/**
 * Rule Locator interface
 */
interface LocatorInterface
{
    /**
     * Retrieve current product label.
     */
    public function getProductLabel(): \Smile\ProductLabel\Api\Data\ProductLabelInterface;
}
