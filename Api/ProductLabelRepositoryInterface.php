<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;

interface ProductLabelRepositoryInterface
{
    /**
     * Retrieve a product label by its id
     *
     * @param int $objectId Id of the product label
     * @return ProductLabelInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $objectId): ProductLabelInterface;

    /**
     * Retrieve a product label by its identifier.
     *
     * @param string $objectIdentifier Identifier of the product label
     * @return ProductLabelInterface
     * @throws NoSuchEntityException
     */
    public function getByIdentifier(string $objectIdentifier): ProductLabelInterface;

    /**
     * Retrieve list of product label
     *
     * @param SearchCriteriaInterface $searchCriteria Search criteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Save a product label
     *
     * @param ProductLabelInterface $label product label
     * @return ProductLabelInterface
     * @throws NoSuchEntityException
     */
    public function save(ProductLabelInterface $label): ProductLabelInterface;

    /**
     * Delete a product label by given ID
     *
     * @param int $plabelId Id of the product label.
     * @return bool
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $plabelId): bool;

    /**
     * Delete a product label by its identifier.
     *
     * @param string $label Identifier of the product label
     * @return bool
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteByIdentifier(string $label): bool;
}
