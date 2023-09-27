<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect as ResultRedirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Ui\Component\MassAction\Filter;
use Smile\ProductLabel\Api\Data\ProductLabelInterfaceFactory as ProductLabelFactory;
use Smile\ProductLabel\Api\ProductLabelRepositoryInterface as ProductLabelRepository;
use Smile\ProductLabel\Model\ProductLabel;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory;

/**
 * Admin Action: productlabel/save
 */
class Save extends AbstractAction implements HttpPostActionInterface
{
    protected DataPersistorInterface $dataPersistor;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ProductLabelFactory $modelFactory,
        ProductLabelRepository $modelRepository,
        DataPersistorInterface $dataPersistor,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context, $coreRegistry, $modelFactory, $modelRepository, $filter, $collectionFactory);
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        /** @var ResultRedirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/');

        /** @var Http $request */
        $request = $this->getRequest();
        $data = $request->getPostValue();
        if (empty($data)) {
            return $resultRedirect;
        }

        // Get the product label id (if edit).
        $productLabelId = null;
        if (!empty($data['product_label_id'])) {
            $productLabelId = (int) $data['product_label_id'];
        }

        // Load the product label.
        $model = $this->initModel($productLabelId);

        // By default, redirect to the edit page of the product label.
        $resultRedirect->setPath('*/*/edit', ['product_label_id' => $productLabelId]);

        /** @var ProductLabel $model */
        $model->populateFromArray($data);

        // Try to save it.
        try {
            $this->modelRepository->save($model);
            if ($productLabelId === null) {
                $resultRedirect->setPath('*/*/edit', ['product_label_id' => $model->getProductLabelId()]);
            }

            // Display success message.
            $this->messageManager->addSuccessMessage((string) __('The product label has been saved.'));
            $this->dataPersistor->clear('smile_productlabel');

            // If requested => redirect to the list.
            if (!$this->getRequest()->getParam('back')) {
                $resultRedirect->setPath('*/*/');
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('smile_productlabel', $data);
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                (string) __('Something went wrong while saving the product label. "%1"', $e->getMessage())
            );
            $this->dataPersistor->set('smile_productlabel', $data);
        }

        return $resultRedirect;
    }
}
