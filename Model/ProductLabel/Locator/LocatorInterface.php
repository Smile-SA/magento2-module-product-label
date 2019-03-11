<?php
/**
 * Rule Locator interface
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\ProductLabel\Model\ProductLabel\Locator;

interface LocatorInterface
{
    /**
     * Retrieve current product label.
     *
     * @return \Smile\ProductLabel\Api\Data\ProductLabelInterface
     */
    public function getProductLabel();
}
