<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Exception;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;

/**
 * Smile Product Label status mass action controller.
 */
class MassStatus extends AbstractAction implements HttpPostActionInterface
{
    /**
     * Execute action
     *
     * @throws LocalizedException|Exception
     */
    public function execute(): Redirect
    {
        $collection     = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        $status         = (int) $this->getRequest()->getParam('is_active');
        $message        = $status === 0
            ? 'A total of %1 product label(s) have been disabled.'
            : 'A total of %1 product label(s) have been enabled.';

        /** @var ProductLabelInterface $productLabel */
        foreach ($collection as $productLabel) {
            $productLabel->setIsActive((bool) $status);
            $this->modelRepository->save($productLabel);
        }

        $this->messageManager->addSuccessMessage((string) __($message, $collectionSize));
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
