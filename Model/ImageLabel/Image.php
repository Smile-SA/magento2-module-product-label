<?php
namespace Smile\ProductLabel\Model\ImageLabel;

use Magento\Framework\UrlInterface;
use Magento\Framework\Filesystem;

/**
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class Image
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
     * @var \Magento\Framework\Filesystem
     */
    protected $fileSystem;
    /**
     * @var \Psr\Log\LoggerInterface
     *
     * @deprecated 101.0.0
     */
    protected $_logger;
    /**
     * @var \Magento\Catalog\Model\ImageUploader
     */
    protected $imageUploader;
    /**
     * @var string
     */
    protected $additionalData = '_additional_data_';
    /**
     * Reference to the attribute instance
     *
     * @var \Magento\Eav\Model\Entity\Attribute\AbstractAttribute
     */
    protected $_attribute;
    /**
     * @param UrlInterface $urlBuilder
     * @param Filesystem $fileSystem
     */
    public function __construct(
        UrlInterface $urlBuilder,
        Filesystem $fileSystem
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->fileSystem = $fileSystem;
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
    /**
     * Gets image name from $value array.
     * Will return empty string in a case when $value is not an array
     *
     * @param array $value Attribute value
     * @return string
     */
    public function getUploadedImageName($value)
    {
        if (is_array($value) && isset($value[0]['name'])) {
            return $value[0]['name'];
        }

        return '';
    }
    /**
     * Get attribute instance
     *
     * @return \Magento\Eav\Model\Entity\Attribute\AbstractAttribute
     * @codeCoverageIgnore
     */
    public function getAttribute()
    {
        return $this->_attribute;
    }
    /**
     * Save uploaded file and set its name to category
     *
     * @param \Magento\Framework\DataObject $object
     * @return \Smile\ProductLabel\Model\ImageLabel\Image
     */
    public function afterSave($object)
    {
        $value = $object->getData($this->additionalData . $this->getAttribute()->getName());
        $imageName = $this->getUploadedImageName($value);
        $this->imageUploader->moveFileFromTmp($imageName);
        return $this;
    }
}