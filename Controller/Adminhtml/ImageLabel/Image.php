<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Controller\Adminhtml\ImageLabel;

/**
 * Class Image admin
 */
class Image extends AbstractUpload
{
    /**
     * Get file id
     */
    public function getFileId(): string
    {
        return 'image';
    }
}
