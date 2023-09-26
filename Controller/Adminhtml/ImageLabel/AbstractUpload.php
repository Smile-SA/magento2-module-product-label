<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ImageLabel;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;

abstract class AbstractUpload extends Action
{
    protected ImageUploader $imageUploader;
    protected JsonFactory $resultJsonFactory;

    public function __construct(
        Context $context,
        ImageUploader $imageUploader,
        JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Upload file controller action
     */
    public function execute(): ResultInterface
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir($this->getFileId());
        } catch (Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultJsonFactory->create()->setData($result);
    }

    /**
     * Get file id
     */
    abstract protected function getFileId(): string;
}
