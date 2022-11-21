<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\ImageLabel;

use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\UrlInterface;

/**
 * Image label class
 */
class Image extends AbstractBackend
{
    /**
     * media sub folder
     */
    protected string $subDir = 'smile_productlabel/imagelabel';

    protected UrlInterface $urlBuilder;

    /**
     * Image constructor.
     *
     * @param UrlInterface $urlBuilder URL Builder
     */
    public function __construct(
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Get images base url
     */
    public function getBaseUrl(): string
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $this->subDir;
    }

    /**
     * Check if temporary file is available for new image upload.
     *
     * @param array $value The value
     */
    public function isTmpFileAvailable(array $value): bool
    {
        return is_array($value) && isset($value[0]['tmp_name']);
    }
}
