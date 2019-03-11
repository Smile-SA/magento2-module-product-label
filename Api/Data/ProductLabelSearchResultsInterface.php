<?php

namespace Smile\ProductLabel\Api\Data;

/**
 * Product Label Search Results Interface
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
interface ProductLabelSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get Product label list.
     *
     * @return \Smile\ProductLabel\Api\Data\ProductLabelInterface[]
     */
    public function getItems();
    /**
     * Set Product label list.
     *
     * @param \Smile\ProductLabel\Api\Data\ProductLabelInterface[] $items list of products labels

     * @return \Smile\ProductLabel\Api\Data\ProductLabelSearchResultsInterface
     */
    public function setItems(array $items);
}