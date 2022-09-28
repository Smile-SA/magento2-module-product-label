<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Magento\Backend\Model\View\Result\Page as ResultPage;
use Magento\Framework\Controller\ResultFactory;

/**
 * Admin Action: productlabel/edit
 */
class Edit extends AbstractAction
{
    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $modelId = (int) $this->getRequest()->getParam('product_label_id');
        $model = $this->initModel($modelId);

        /** @var ResultPage $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $breadcrumbTitle = $model->getProductLabelId() ? __('Edit Product Label') : __('New Product Label');
        $resultPage
            ->setActiveMenu('Smile_ProductLabel::manage')
            ->addBreadcrumb(__('Smile Product Label'), __('Smile Product Label'))
            ->addBreadcrumb($breadcrumbTitle, $breadcrumbTitle);

        $title = $model->getProductLabelId() ?
            __("Edit product label #%1", $model->getProductLabelId()) : __('New product label');

        $resultPage->getConfig()->getTitle()->prepend(__('Manage Smile_ProductLabel'));
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
