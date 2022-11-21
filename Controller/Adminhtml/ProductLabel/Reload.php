<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;
use Smile\ProductLabel\Api\Data\ProductLabelInterfaceFactory;
use Smile\ProductLabel\Api\ProductLabelRepositoryInterface;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory;

/**
 * Reload controller for product label edition : used to refresh the form after attribute_id is chosen.
 */
class Reload extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Smile_ProductLabel::manage';

    protected ?PageFactory $resultPageFactory = null;

    /**
     * Core registry
     */
    protected Registry $coreRegistry;

    protected DataPersistorInterface $dataPersistor;

    protected Filter $filter;

    protected CollectionFactory $collectionFactory;

    protected ProductLabelRepositoryInterface $productLabelRepository;

    protected ForwardFactory $resultForwardFactory;

    /**
     * Product Label Factory
     */
    protected ProductLabelInterfaceFactory $productLabelFactory;

    /**
     * Reload constructor.
     *
     * @param Context $context UI Component context
     * @param PageFactory $resultPageFactory Result Page Factory
     * @param Registry $coreRegistry Core Registry
     * @param DataPersistorInterface $dataPersistor Data Persistor
     * @param Filter $filter Action Filter
     * @param CollectionFactory $collectionFactory Product Label Collection Factory
     * @param ProductLabelRepositoryInterface $productLabelRepository Product Label Repository
     * @param ProductLabelInterfaceFactory $productLabelFactory Product Label Factory
     */
    public function __construct(
        Context                         $context,
        PageFactory                     $resultPageFactory,
        Registry                        $coreRegistry,
        DataPersistorInterface          $dataPersistor,
        Filter                          $filter,
        CollectionFactory               $collectionFactory,
        ProductLabelRepositoryInterface $productLabelRepository,
        ProductLabelInterfaceFactory    $productLabelFactory,
        ForwardFactory $resultForwardFactory
    ) {
        parent::__construct($context);

        $this->resultPageFactory      = $resultPageFactory;
        $this->resultForwardFactory   = $resultForwardFactory;
        $this->coreRegistry           = $coreRegistry;
        $this->dataPersistor          = $dataPersistor;
        $this->filter                 = $filter;
        $this->collectionFactory      = $collectionFactory;
        $this->productLabelRepository = $productLabelRepository;
        $this->productLabelFactory    = $productLabelFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        if (!$this->getRequest()->getParam('set')) {
            return $this->resultForwardFactory->create()->forward('noroute');
        }

        $identifier = $this->getRequest()->getParam('product_label_id');
        $model      = $this->productLabelFactory->create();

        if ($identifier) {
            $model = $this->productLabelRepository->getById($identifier);
        }

        $model->setAttributeId((int) $this->getRequest()->getParam('set'));
        $this->coreRegistry->register('current_productlabel', $model);

        /** @var \Magento\Framework\View\Result\Layout $resultLayout */
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);

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

        $resultPage->setActiveMenu('Smile_ProductLabel::rule')
            ->addBreadcrumb((string) __('Product Label'), (string) __('Product Label'));

        return $resultPage;
    }
}
