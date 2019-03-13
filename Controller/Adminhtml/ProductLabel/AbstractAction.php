<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Registry;
use Smile\ProductLabel\Api\Data\ProductLabelInterface as ProductLabel;
use Smile\ProductLabel\Api\Data\ProductLabelInterfaceFactory as ProductLabelFactory;
use Smile\ProductLabel\Api\ProductLabelRepositoryInterface as ProductLabelRepository;

/**
 * Abstract Admin action for product label
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
abstract class AbstractAction extends Action
{
    /**
     * Authorization level.
     */
    const ADMIN_RESOURCE = 'Smile_ProductLabel::manage';

    /**
     * @var ProductLabelFactory
     */
    protected $modelFactory;

    /**
     * @var ProductLabelRepository
     */
    protected $modelRepository;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * @var \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * AbstractAction constructor.
     *
     * @param Context                                                                $context           UI Component context
     * @param Registry                                                               $coreRegistry      Core Registry
     * @param ProductLabelFactory                                                    $modelFactory      Product Label Factory
     * @param ProductLabelRepository                                                 $modelRepository   Product Label Repository
     * @param \Magento\Ui\Component\MassAction\Filter                                $filter            Action Filter
     * @param \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory $collectionFactory Product Label Collection Factory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ProductLabelFactory $modelFactory,
        ProductLabelRepository $modelRepository,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory $collectionFactory
    ) {
        $this->modelFactory = $modelFactory;
        $this->modelRepository = $modelRepository;
        $this->coreRegistry = $coreRegistry;
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;

        parent::__construct($context);
    }

    /**
     * Init the current model.
     *
     * @param int|null $labelId Product Label ID
     *
     * @return ProductLabel
     * @throws NotFoundException
     */
    protected function initModel($labelId)
    {
        /** @var \Smile\ProductLabel\Model\ProductLabel $model */
        $model = $this->modelFactory->create();

        // Initial checking.
        if ($labelId) {
            try {
                $model = $this->modelRepository->getById($labelId);
            } catch (NoSuchEntityException $e) {
                throw new NotFoundException(__('This product label does not exist.'));
            }
        }

        // Register model to use later in blocks.
        $this->coreRegistry->register('current_productlabel', $model);

        return $model;
    }
}
