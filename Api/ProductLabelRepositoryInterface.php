<?php

namespace Smile\ProductLabel\Api;

/**
 * Product Label Repository Interface
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
interface ProductLabelRepositoryInterface
{
    /**
     * Retrieve a productlabel by its id
     *
     * @param int $objectId
     * @return \Smile\ProductLabel\Api\Data\ProductLabelInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($objectId);
    /**
     * Retrieve a productlabel by its identifier.
     *
     * @param string $objectIdentifier
     * @return \Smile\ProductLabel\Api\Data\ProductLabelInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByIdentifier($objectIdentifier);
    /**
     * Retrieve list of productlabel
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria Search criteria
     *
     * @return \Smile\ProductLabel\Api\Data\ProductLabelInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
    /**
     * Save a productlabel
     *
     * @param \Smile\ProductLabel\Api\Data\ProductLabelInterface $plabel productlabel
     *
     * @return \Smile\ProductLabel\Api\Data\ProductLabelInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function save(\Smile\ProductLabel\Api\Data\ProductLabelInterface $plabel);
    /**
     * Delete a productlabel by given ID
     *
     * @param int $plabelId Id of the productlabel.
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($plabelId);
    /**
     * Delete a productlabel by its identifier.
     *
     * @param string $plabel
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteByIdentifier($plabel);
}