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