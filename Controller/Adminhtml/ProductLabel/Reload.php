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

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Magento\Backend\App\Action;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory;

/**
 * Reload controller for product label edition : used to refresh the form after attribute_id is chosen.
 *
 * @category  Smile
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class Reload extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Smile_ProductLabel::manage';

    protected ?\Magento\Framework\View\Result\PageFactory $resultPageFactory = null;

    /**
     * Core registry
     */
    protected \Magento\Framework\Registry $coreRegistry;

    protected \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor;

    protected \Magento\Ui\Component\MassAction\Filter $filter;

    protected \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory $collectionFactory;

    protected \Smile\ProductLabel\Api\ProductLabelRepositoryInterface $productLabelRepository;

    /**
     * Product Label Factory
     */
    protected \Smile\ProductLabel\Api\Data\ProductLabelInterfaceFactory $productLabelFactory;

    /**
     * Reload constructor.
     *
     * @param Action\Context                                            $context                UI Component context
     * @param \Magento\Framework\View\Result\PageFactory                $resultPageFactory      Result Page Factory
     * @param \Magento\Framework\Registry                               $coreRegistry           Core Registry
     * @param \Magento\Framework\App\Request\DataPersistorInterface     $dataPersistor          Data Persistor
     * @param \Magento\Ui\Component\MassAction\Filter                   $filter                 Action Filter
     * @param CollectionFactory                                         $collectionFactory      Product Label Collection Factory
     * @param \Smile\ProductLabel\Api\ProductLabelRepositoryInterface   $productLabelRepository Product Label Repository
     * @param \Smile\ProductLabel\Api\Data\ProductLabelInterfaceFactory $productLabelFactory    Product Label Factory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory $collectionFactory,
        \Smile\ProductLabel\Api\ProductLabelRepositoryInterface $productLabelRepository,
        \Smile\ProductLabel\Api\Data\ProductLabelInterfaceFactory $productLabelFactory
    ) {
        parent::__construct($context);

        $this->resultPageFactory      = $resultPageFactory;
        $this->coreRegistry           = $coreRegistry;
        $this->dataPersistor          = $dataPersistor;
        $this->filter                 = $filter;
        $this->collectionFactory      = $collectionFactory;
        $this->productLabelRepository = $productLabelRepository;
        $this->productLabelFactory    = $productLabelFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        if (!$this->getRequest()->getParam('set')) {
            return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_FORWARD)->forward('noroute');
        }

        $identifier = $this->getRequest()->getParam('product_label_id');
        $model      = $this->productLabelFactory->create();

        if ($identifier) {
            $model = $this->productLabelRepository->getById($identifier);
        }

        $model->setAttributeId((int) $this->getRequest()->getParam('set'));
        $this->coreRegistry->register('current_productlabel', $model);

        /** @var \Magento\Framework\View\Result\Layout $resultLayout */
        $resultLayout = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_LAYOUT);

        $resultLayout->getLayout()->getUpdate()->removeHandle('default');
        $resultLayout->setHeader('Content-Type', 'application/json', true);

        return $resultLayout;
    }

    /**
     * Create result page
     */
    protected function createPage(): \Magento\Backend\Model\View\Result\Page
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        $resultPage->setActiveMenu('Smile_ProductLabel::rule')->addBreadcrumb(__('Product Label'), __('Product Label'));

        return $resultPage;
    }
}
