<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Exception;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;

/**
 * Smile Product Label status mass action controller.
 */
class MassStatus extends AbstractAction implements HttpPostActionInterface
{
    /**
     * Execute action
     *
     * @throws \Magento\Framework\Exception\LocalizedException|Exception
     */
    public function execute(): Redirect
    {
        $collection     = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        $status         = (int) $this->getRequest()->getParam('is_active');
        // @codingStandardsIgnoreStart
        $message        = ($status === 0) ? 'A total of %1 product label(s) have been disabled.' : 'A total of %1 product label(s) have been enabled.';
        // @codingStandardsIgnoreEnd

        /** @var ProductLabelInterface $plabel */
        foreach ($collection as $plabel) {
            $plabel->setIsActive((bool) $status);
            $this->modelRepository->save($plabel);
        }

        $this->messageManager->addSuccessMessage((string) __($message, $collectionSize));

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
