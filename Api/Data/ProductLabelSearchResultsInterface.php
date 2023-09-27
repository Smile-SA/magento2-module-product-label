<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ProductLabelSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Product label list.
     *
     * @return ProductLabelInterface[]
     */
    public function getItems(): array;

    /**
     * Set Product label list.
     */
    public function setItems(array $items): ProductLabelSearchResultsInterface;
}
