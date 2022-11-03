<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ImageLabel;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class AbstractUpload
 */
abstract class AbstractUpload extends Action
{
    /**
     * Image uploader
     */
    protected ImageUploader $imageUploader;

    /**
     * Image uploader
     */
    protected JsonFactory $resultJsonFactory;

    /**
     * AbstractUpload constructor.
     *
     * @param Context $context UI Component context
     * @param ImageUploader $imageUploader Image uploader
     */
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
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultJsonFactory->create()->setData($result);
    }

    /**
     * Get file id
     */
    abstract protected function getFileId(): string;
}
