<?php
/**
 * DISCLAIMER
 *
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

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect as ResultRedirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Smile\ProductLabel\Api\Data\ProductLabelInterfaceFactory as ProductLabelFactory;
use Smile\ProductLabel\Api\ProductLabelRepositoryInterface as ProductLabelRepository;
use Smile\ProductLabel\Model\ProductLabel;

/**
 * Admin Action: productlabel/save
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class Save extends AbstractAction
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * Save constructor.
     *
     * @param Context                                                                $context           UI Component context
     * @param Registry                                                               $coreRegistry      Core Registry
     * @param ProductLabelFactory                                                    $modelFactory      Product Label Factory
     * @param ProductLabelRepository                                                 $modelRepository   Product Label Repository
     * @param DataPersistorInterface                                                 $dataPersistor     Data Persistor
     * @param \Magento\Ui\Component\MassAction\Filter                                $filter            Action Filter
     * @param \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory $collectionFactory Product Label Collection Factory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ProductLabelFactory $modelFactory,
        ProductLabelRepository $modelRepository,
        DataPersistorInterface $dataPersistor,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory $collectionFactory
    ) {
        parent::__construct($context, $coreRegistry, $modelFactory, $modelRepository, $filter, $collectionFactory);

        $this->dataPersistor = $dataPersistor;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var ResultRedirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/');

        /** @var \Magento\Framework\App\Request\Http $request */
        $request = $this->getRequest();
        $data = $request->getPostValue();
        if (empty($data)) {
            return $resultRedirect;
        }

        // Get the product label id (if edit).
        $productlabelId = null;
        if (!empty($data['product_label_id'])) {
            $productlabelId = (int) $data['product_label_id'];
        }

        // Load the product label.
        $model = $this->initModel($productlabelId);



        // By default, redirect to the edit page of the product label.
        $resultRedirect->setPath('*/*/edit', ['product_label_id' => $productlabelId]);

        /** @var ProductLabel $model */
        $model->populateFromArray($data);

        // Try to save it.
        try {
            $this->modelRepository->save($model);
            if ($productlabelId === null) {
                $resultRedirect->setPath('*/*/edit', ['product_label_id' => $model->getProductLabelId()]);
            }

            // Display success message.
            $this->messageManager->addSuccessMessage(__('The product label has been saved.'));
            $this->dataPersistor->clear('smile_productlabel');

            // If requested => redirect to the list.
            if (!$this->getRequest()->getParam('back')) {
                $resultRedirect->setPath('*/*/');
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('smile_productlabel', $data);
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __('Something went wrong while saving the product label. "%1"', $e->getMessage())
            );
            $this->dataPersistor->set('smile_productlabel', $data);
        }

        return $resultRedirect;
    }
}
