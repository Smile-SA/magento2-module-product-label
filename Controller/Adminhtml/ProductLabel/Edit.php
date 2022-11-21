<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Magento\Backend\Model\View\Result\Page as ResultPage;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Admin Action: productlabel/edit
 */
class Edit extends AbstractAction implements HttpGetActionInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        $modelId = (int) $this->getRequest()->getParam('product_label_id');
        $model = $this->initModel($modelId);

        /** @var ResultPage $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $breadcrumbTitle = $model->getProductLabelId() ?
            (string) __('Edit Product Label') : (string) __('New Product Label');
        $resultPage
            ->setActiveMenu('Smile_ProductLabel::manage')
            ->addBreadcrumb((string) __('Smile Product Label'), (string) __('Smile Product Label'))
            ->addBreadcrumb($breadcrumbTitle, $breadcrumbTitle);

        $title = $model->getProductLabelId() ?
            (string) __("Edit product label #%1", $model->getProductLabelId()) : (string) __('New product label');

        $resultPage->getConfig()->getTitle()->prepend((string) __('Manage Smile_ProductLabel'));
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
