<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

/**
 *  Admin Action: productlabel/massDelete
 */
class MassDelete extends AbstractAction
{
    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute(): \Magento\Framework\Controller\ResultInterface
    {
        $collection     = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $productLabel) {
            $this->modelRepository->deleteById($productLabel->getId());
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 product label(s) have been deleted.', $collectionSize)
        );

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
