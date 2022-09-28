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

namespace Smile\ProductLabel\Api\Data;

/**
 * Product Label Search Results Interface
 *
 * @category  Smile
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
interface ProductLabelSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get Product label list.
     *
     * @return \Smile\ProductLabel\Api\Data\ProductLabelInterface[]
     */
    public function getItems(): array;

    /**
     * Set Product label list.
     *
     * @param \Smile\ProductLabel\Api\Data\ProductLabelInterface[] $items list of products labels
     * @return \Smile\ProductLabel\Api\Data\ProductLabelSearchResultsInterface
     */
    public function setItems(array $items): \Smile\ProductLabel\Api\Data\ProductLabelSearchResultsInterface;
}
