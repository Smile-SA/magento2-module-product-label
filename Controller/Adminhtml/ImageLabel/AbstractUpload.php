<?php

declare(strict_types=1);

/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Controller\Adminhtml\ImageLabel;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class AbstractUpload
 *
 * @category  Smile
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
abstract class AbstractUpload extends \Magento\Backend\App\Action
{
    /**
     * Image uploader
     */
    protected \Magento\Catalog\Model\ImageUploader $imageUploader;

    /**
     * AbstractUpload constructor.
     *
     * @param \Magento\Backend\App\Action\Context  $context       UI Component context
     * @param \Magento\Catalog\Model\ImageUploader $imageUploader Image uploader
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Catalog\Model\ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Upload file controller action
     */
    public function execute(): \Magento\Framework\Controller\ResultInterface
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir($this->getFileId());
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }

    abstract protected function getFileId(): string;
}
