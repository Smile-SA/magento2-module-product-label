<?php

declare(strict_types=1);

/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Api;

/**
 * Product Label Repository Interface
 *
 * @category  Smile
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
interface ProductLabelRepositoryInterface
{
    /**
     * Retrieve a product label by its id
     *
     * @param int $objectId Id of the product label
     * @return \Smile\ProductLabel\Api\Data\ProductLabelInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $objectId): \Smile\ProductLabel\Api\Data\ProductLabelInterface;

    /**
     * Retrieve a product label by its identifier.
     *
     * @param string $objectIdentifier Identifier of the product label
     * @return \Smile\ProductLabel\Api\Data\ProductLabelInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByIdentifier(string $objectIdentifier): \Smile\ProductLabel\Api\Data\ProductLabelInterface;

    /**
     * Retrieve list of product label
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria Search criteria
     * @return \Smile\ProductLabel\Api\Data\ProductLabelInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria): \Smile\ProductLabel\Api\Data\ProductLabelInterface;

    /**
     * Save a product label
     *
     * @param \Smile\ProductLabel\Api\Data\ProductLabelInterface $plabel product label
     * @return \Smile\ProductLabel\Api\Data\ProductLabelInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function save(\Smile\ProductLabel\Api\Data\ProductLabelInterface $plabel): \Smile\ProductLabel\Api\Data\ProductLabelInterface;

    /**
     * Delete a product label by given ID
     *
     * @param int $plabelId Id of the product label.
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $plabelId): bool;

    /**
     * Delete a product label by its identifier.
     *
     * @param string $plabel Identifier of the product label
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteByIdentifier(string $plabel): bool;
}
