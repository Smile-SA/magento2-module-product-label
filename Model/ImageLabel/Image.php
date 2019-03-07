<?php
namespace Smile\ProductLabel\Model\ImageLabel;

use Magento\Framework\UrlInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
/**
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class Image extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    /**
     * media sub folder
     * @var string
     */
    protected $subDir = 'smile_productlabel/tmp/imagelabel';

    /**
     * url builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * Image constructor.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param UrlInterface                          $urlBuilder
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        UrlInterface $urlBuilder
    )
    {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * get images base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]).$this->subDir;
    }

    /**
     * Check if temporary file is available for new image upload.
     *
     * @param array $value
     * @return bool
     */
    public function isTmpFileAvailable($value)
    {
        return is_array($value) && isset($value[0]['tmp_name']);
    }

}