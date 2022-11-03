<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Admin Action: productlabel/index
 */
class Index extends AbstractAction implements HttpGetActionInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        $breadMain = (string) __('Manage Product labels');

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Smile_ProductLabel::manage');
        $resultPage->addBreadcrumb((string) __('Smile Product Label'), (string) __('Smile Product Label'));
        $resultPage->getConfig()->getTitle()->prepend($breadMain);

        return $resultPage;
    }
}
