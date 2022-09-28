<?php

declare(strict_types=1);

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Model\ProductLabel\Locator;

/**
 * Rule Locator interface
 *
 * @category  Smile
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
interface LocatorInterface
{
    /**
     * Retrieve current product label.
     */
    public function getProductLabel(): \Smile\ProductLabel\Api\Data\ProductLabelInterface;
}
