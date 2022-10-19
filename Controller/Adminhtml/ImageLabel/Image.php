<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ImageLabel;

use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class Image admin
 */
class Image extends AbstractUpload implements HttpGetActionInterface
{
    /**
     * Get file id
     */
    public function getFileId(): string
    {
        return 'image';
    }
}
