<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;

interface ProductLabelRepositoryInterface
{
    /**
     * Retrieve a product label by its id
     *
     * @throws NoSuchEntityException
     */
    public function getById(int $objectId): ProductLabelInterface;

    /**
     * Retrieve a product label by its identifier.
     *
     * @throws NoSuchEntityException
     */
    public function getByIdentifier(string $objectIdentifier): ProductLabelInterface;

    /**
     * Retrieve list of product label
     */
    public function getList(?SearchCriteriaInterface $searchCriteria): SearchResults;

    /**
     * Save a product label
     *
     * @throws NoSuchEntityException
     */
    public function save(ProductLabelInterface $label): ProductLabelInterface;

    /**
     * Delete a product label by given ID
     *
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $productLabelId): bool;

    /**
     * Delete a product label by its identifier.
     *
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteByIdentifier(string $label): bool;
}
