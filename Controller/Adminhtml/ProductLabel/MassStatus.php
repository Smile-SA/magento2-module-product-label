<?php
/**
 * Smile Product Label status mass action controller.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

class MassStatus extends AbstractAction
{
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection     = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        $status         = (int) $this->getRequest()->getParam('is_active');
        $message        = ($status === 0) ? 'A total of %1 rules(s) have been disabled.' : 'A total of %1 rules(s) have been enabled.';

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
