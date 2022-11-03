<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ImageLabel;

use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Class Image admin
 */
class Image extends AbstractUpload implements HttpPostActionInterface
{
    /**
     * Get file id
     */
    public function getFileId(): string
    {
        return 'image';
    }
}
