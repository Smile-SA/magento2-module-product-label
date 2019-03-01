<?php

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Magento\Framework\Controller\Result\Redirect as ResultRedirect;
use Magento\Framework\Controller\ResultFactory;

/**
 *  Admin Action: productlabel/massDelete
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class MassDelete extends AbstractAction
{

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var ResultRedirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/index');

        $productlabelIds = $this->getRequest()->getParam('selected', []);

        if (!is_array($productlabelIds) || count($productlabelIds) < 1) {
            $this->messageManager->addErrorMessage(__('Please select product labels.'));
            return $resultRedirect;
        }

        try {
            foreach ($productlabelIds as $productlabelId) {
                $this->modelRepository->deleteById((int) $productlabelId);
            }
            $this->messageManager->addSuccessMessage(__('Total of %1 ProductLabel(s) were deleted.', count($productlabelIds)));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect;
    }
}