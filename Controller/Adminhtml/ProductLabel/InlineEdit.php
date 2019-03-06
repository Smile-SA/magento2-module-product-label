<?php

namespace Smile\ProductLabel\Controller\Adminhtml\ProductLabel;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Admin Action: productlabel/inlineEdit
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class InlineEdit extends AbstractAction
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
        $error = false;
        $messages = [];

        if (!$this->getRequest()->getParam('isAjax')) {
            $messages[] = __('Ajax call needed.');
            $error = true;
            return $this->getResult($messages, $error);
        }

        $postItems = $this->getRequest()->getParam('items', []);
        if (!count($postItems)) {
            $messages[] = __('Please correct the data sent.');
            $error = true;
            return $this->getResult($messages, $error);
        }

        foreach (array_keys($postItems) as $modelId) {
            try {
                // Load the ProductLabel
                $model = $this->modelRepository->getById((int) $modelId);

                /** @var \Smile\ProductLabel\Model\ProductLabel $model */
                $model->populateFromArray($postItems[$modelId]);

                // Save the ProductLabel
                $this->modelRepository->save($model);
            } catch (\Exception $e) {
                $messages[] = '[Product Label #' . $modelId . '] ' . __($e->getMessage());
                $error = true;
            }
        }

        return $this->getResult($messages, $error);
    }

    public function getResult($messages, $error) {

        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData(
            [
                'messages' => $messages,
                'error' => $error,
            ]
        );

        return $resultJson;
    }
}