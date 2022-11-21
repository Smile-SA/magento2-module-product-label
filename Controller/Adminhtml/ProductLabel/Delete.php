<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Redirect as ResultRedirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;

/**
 * Admin Action: productlabel/delete
 */
class Delete extends AbstractAction implements HttpGetActionInterface
{
    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @throws NotFoundException
     */
    public function execute(): ResultInterface
    {
        /** @var ResultRedirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/index');

        try {
            $productLabelId = (int) $this->getRequest()->getParam('product_label_id');
            $this->modelRepository->deleteById($productLabelId);

            $this->messageManager->addSuccessMessage(
                (string) __('The product label "%1" has been deleted.', $productLabelId)
            );
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage((string) __('The product label to delete does not exist.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect;
    }
}
