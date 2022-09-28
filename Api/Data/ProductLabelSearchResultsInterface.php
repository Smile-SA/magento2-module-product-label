<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Api\Data;

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
