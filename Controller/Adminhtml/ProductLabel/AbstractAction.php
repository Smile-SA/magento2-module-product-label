<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Registry;
use Magento\Ui\Component\MassAction\Filter;
use Smile\ProductLabel\Api\Data\ProductLabelInterface as ProductLabel;
use Smile\ProductLabel\Api\Data\ProductLabelInterfaceFactory as ProductLabelFactory;
use Smile\ProductLabel\Api\ProductLabelRepositoryInterface as ProductLabelRepository;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory;

/**
 * Abstract Admin action for product label
 */
abstract class AbstractAction extends Action
{
    /** Authorization level. */
    public const ADMIN_RESOURCE = 'Smile_ProductLabel::manage';

    protected ProductLabelFactory $modelFactory;
    protected ProductLabelRepository $modelRepository;
    protected Registry $coreRegistry;
    protected Filter $filter;
    protected CollectionFactory $collectionFactory;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ProductLabelFactory $modelFactory,
        ProductLabelRepository $modelRepository,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->modelFactory = $modelFactory;
        $this->modelRepository = $modelRepository;
        $this->coreRegistry = $coreRegistry;
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Init the current model.
     *
     * @throws NotFoundException
     */
    protected function initModel(?int $labelId): ProductLabel
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
