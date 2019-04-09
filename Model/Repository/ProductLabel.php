<?php
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Model\Repository;

use Magento\Framework\Api\SearchCriteriaInterface;
use Smile\ProductLabel\Api\ProductLabelRepositoryInterface;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;
use Smile\ProductLabel\Api\Data\ProductLabelInterfaceFactory;
use Smile\ProductLabel\Api\Data\ProductLabelSearchResultsInterfaceFactory;
use Smile\ProductLabel\Model\Repository\Manager as RepositoryManager;
use Smile\ProductLabel\Model\Repository\ManagerFactory as RepositoryManagerFactory;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel as ProductLabelResourceModel;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory as ProductLabelCollectionFactory;

/**
 * ProductLabel Repository
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class ProductLabel implements ProductLabelRepositoryInterface
{

    /**
     * @var RepositoryManager
     */
    protected $productLabelRepositoryManager;

    /**
     * ProductLabel constructor.
     *
     * @param ManagerFactory                            $repositoryManagerFactory   Repository Manager
     * @param ProductLabelInterfaceFactory              $objectFactory              Object Factory
     * @param ProductLabelResourceModel                 $objectResource             Object Resource
     * @param ProductLabelCollectionFactory             $objectCollectionFactory    Object Collection Factory
     * @param ProductLabelSearchResultsInterfaceFactory $objectSearchResultsFactory Object Search Result Factory
     */
    public function __construct(
        RepositoryManagerFactory $repositoryManagerFactory,
        ProductLabelInterfaceFactory $objectFactory,
        ProductLabelResourceModel $objectResource,
        ProductLabelCollectionFactory $objectCollectionFactory,
        ProductLabelSearchResultsInterfaceFactory $objectSearchResultsFactory
    ) {
        $this->productLabelRepositoryManager = $repositoryManagerFactory->create(
            [
                'objectFactory'              => $objectFactory,
                'objectResource'             => $objectResource,
                'objectCollectionFactory'    => $objectCollectionFactory,
                'objectSearchResultsFactory' => $objectSearchResultsFactory,
                'identifierFieldName'        => ProductLabelInterface::PRODUCTLABEL_ID,
            ]
        );
    }

    /**
     * Retrieve a productLabel by its id
     *
     * @param int $objectId Product Label identifier.
     *
     * @return \Smile\ProductLabel\Api\Data\ProductLabelInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($objectId)
    {
        return $this->productLabelRepositoryManager->getEntityById($objectId);
    }

    /**
     * Retrieve a productLabel by its identifier.
     *
     * @param string $objectIdentifier Product Label identifier.
     *
     * @return \Smile\ProductLabel\Api\Data\ProductLabelInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByIdentifier($objectIdentifier)
    {
        return $this->productLabelRepositoryManager->getEntityByIdentifier($objectIdentifier);
    }

    /**
     * Retrieve productLabels which match a specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria Search Criteria
     *
     * @return \Smile\ProductLabel\Api\Data\ProductLabelSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this->productLabelRepositoryManager->getEntities($searchCriteria);
    }

    /**
     * Save a productLabel.
     *
     * @param \Smile\ProductLabel\Api\Data\ProductLabelInterface $object Product Label
     *
     * @return \Smile\ProductLabel\Api\Data\ProductLabelInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(ProductLabelInterface $object)
    {
        return $this->productLabelRepositoryManager->saveEntity($object);
    }

    /**
     * Delete a productLabel by its id.
     *
     * @param int $objectId The object Id
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($objectId)
    {
        return $this->productLabelRepositoryManager->deleteEntityById($objectId);
    }

    /**
     * Delete a productLabel by its identifier.
     *
     * @param \Smile\ProductLabel\Api\Data\ProductLabelInterface $object Product Label
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteByIdentifier($object)
    {
        return $this->productLabelRepositoryManager->deleteEntityByIdentifier($object);
    }
}
