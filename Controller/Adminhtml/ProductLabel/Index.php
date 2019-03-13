<?php
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Magento\Framework\Controller\ResultFactory;

/**
 * Admin Action: productlabel/index
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class Index extends AbstractAction
{

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $breadMain = __('Manage Product labels');

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Smile_ProductLabel::manage');
        $resultPage->addBreadcrumb(__('Smile Product Label'), __('Smile Product Label'));
        $resultPage->getConfig()->getTitle()->prepend($breadMain);

        return $resultPage;
    }
}
