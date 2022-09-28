<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

/**
 * Smile Product Label status mass action controller.
 */
class MassStatus extends AbstractAction
{
    /**
     * Execute action
     *
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute(): \Magento\Backend\Model\View\Result\Redirect
    {
        $collection     = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        $status         = (int) $this->getRequest()->getParam('is_active');
        // @codingStandardsIgnoreStart
        $message        = ($status === 0) ? 'A total of %1 product label(s) have been disabled.' : 'A total of %1 product label(s) have been enabled.';
        // @codingStandardsIgnoreEnd

        /** @var \Smile\ProductLabel\Api\Data\ProductLabelInterface $plabel */
        foreach ($collection as $plabel) {
            $plabel->setIsActive($status);
            $this->modelRepository->save($plabel);
        }

        $this->messageManager->addSuccessMessage(__($message, $collectionSize));

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
