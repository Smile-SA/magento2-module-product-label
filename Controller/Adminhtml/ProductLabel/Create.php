<?php
/**
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

/**
 * Rule Adminhtml Index controller.
 *
 *
 **/
class Create extends AbstractAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->createPage();

        $resultPage->setActiveMenu('Smile_ProductLabel::manage');
        $resultPage->getConfig()->getTitle()->prepend(__('New Product Label'));

        return $resultPage;
    }
}
