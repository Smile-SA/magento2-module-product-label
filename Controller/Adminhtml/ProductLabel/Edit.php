<?php

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\Model\View\Result\Page as ResultPage;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Admin Action: productlabel/edit
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
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

        $this->coreRegistry->register('current_productLabel', $model);

        $breadcrumbTitle = $model->getId() ? __('Edit Product Label') : __('New Product Label');
        $resultPage
            ->setActiveMenu('Smile_ProductLabel::manage')
            ->addBreadcrumb(__('Smile Product Label'), __('Smile Product Label'))
            ->addBreadcrumb($breadcrumbTitle, $breadcrumbTitle);

        $resultPage->getConfig()->getTitle()->prepend(__('Manage Smile_ProductLabel'));
        $resultPage->getConfig()->getTitle()->prepend(
            $model->getId()
                ? __("Edit product label #%1", $model->getIdentifier())
                : __('New product label')
        );


        return $resultPage;
    }
}