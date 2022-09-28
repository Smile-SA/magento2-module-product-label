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

namespace Smile\ProductLabel\Model\ImageLabel;

use Magento\Framework\UrlInterface;

/**
 * @category  Smile
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class Image extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    /**
     * media sub folder
     */
    protected string $subDir = 'smile_productlabel/imagelabel';

    /**
     * url builder
     */
    protected \Magento\Framework\UrlInterface $urlBuilder;

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
     * get images base url
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
