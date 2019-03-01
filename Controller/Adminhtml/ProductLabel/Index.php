<?php

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Magento\Framework\Controller\ResultFactory;

/**
 * Admin Action: productlabel/index
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class Index extends AbstractAction
{

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Smile_ProductLabel::manage');
        $resultPage->addBreadcrumb(__('Smile Product Label'), __('Smile Product Label'));
        return $resultPage;
    }
}

