<?php

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
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
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
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ProductLabelFactory $modelFactory
     * @param ProductLabelRepository $modelRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ProductLabelFactory $modelFactory,
        ProductLabelRepository $modelRepository
    ) {
        $this->modelFactory = $modelFactory;
        $this->modelRepository = $modelRepository;
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context);
    }

    /**
     * Init the current model.
     *
     * @param int|null $modelId
     * @return ProductLabel
     * @throws NotFoundException
     */
    protected function initModel($modelId)
    {
        /** @var \Smile\ProductLabel\Model\ProductLabel $model */
        $model = $this->modelFactory->create();

        // Initial checking
        if ($modelId) {
            try {
                $model = $this->modelRepository->getById($modelId);
            } catch (NoSuchEntityException $e) {
                throw new NotFoundException(__('This product label does not exist.'));
            }
        }

        // Register model to use later in blocks
        $this->coreRegistry->register('current_productlabel', $model);

        return $model;
    }
}