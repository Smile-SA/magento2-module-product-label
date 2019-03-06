<?php
/**
 * Reload controller for product label edition : used to refresh the form after attribute_id is chosen.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;


class Reload extends AbstractAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        if (!$this->getRequest()->getParam('set')) {
            return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_FORWARD)->forward('noroute');
        }

        $identifier = $this->getRequest()->getParam('product_label_id');
        $model      = $this->modelFactory->create();

        if ($identifier) {
            $model = $this->modelRepository->getById($identifier);
        }

        $model->setAttributeId((int) $this->getRequest()->getParam('set'));
        $this->coreRegistry->register('current_productlabel', $model);

        /** @var \Magento\Framework\View\Result\Layout $resultLayout */
        $resultLayout = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_LAYOUT);

        $resultLayout->getLayout()->getUpdate()->removeHandle('default');
        $resultLayout->setHeader('Content-Type', 'application/json', true);

        return $resultLayout;
    }
    
}
