<?php

namespace Smile\ProductLabel\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Smile\ProductLabel\Api\Data\ProductLabelInterface;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel as ProductLabelResource;
/**
 * Product Label Model
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class ProductLabel extends AbstractModel implements IdentityInterface,ProductLabelInterface
{
    /**
     * @var string
     */
    const CACHE_TAG = 'smile_productlabel';

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ProductLabelResource::class);
    }

    /**
     * ProductLabel constructor.
     *
     * @param \Magento\Framework\Model\Context                             $context
     * @param \Magento\Framework\Registry                                  $registry
     * @param \Magento\Store\Model\StoreManagerInterface                   $storeManager
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null           $resourceCollection
     * @param array                                                        $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {

        $this->storeManager = $storeManager;
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];

    }

    /**
     * Get field: is_active.
     *
     * @return bool
     */
    public function isActive()
    {
        return (bool) $this->getData(self::IS_ACTIVE);
    }

    /**
     * Get field: product_label_id.
     *
     * @return int|null
     */
    public function getProductLabelId()
    {
        return $this->getId();
    }
    /**
     * Get field: identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return (string) $this->getData(self::PRODUCTLABEL_IDENTIFIER);
    }
    /**
     * Get field: name.
     *
     * @return string
     */
    public function getName()
    {
        return (int) $this->getData(self::PRODUCTLABEL_NAME);
    }
    /**
     * Get field: attribute_id
     *
     * @return int
     */
    public function getAttributeId(): int
    {
        return (int) $this->getData(self::ATTRIBUTE_ID);
    }
    /**
     * Get field: option_id
     *
     * @return int
     */
    public function getOptionId(): int
    {
        return (int) $this->getData(self::OPTION_ID);
    }

    /**
     * Get field: image
     *
     * @return string
     */
    public function getProductLabelImage()
    {
        return (string) $this->getData(self::PRODUCTLABEL_IMAGE);
    }
    /**
     * Get field: position_category_list
     *
     * @return string
     */
    public function getPositionCategoryList()
    {
        return (string) $this->getData(self::PRODUCTLABEL_POSITION_CATEGORY_LIST);
    }
    /**
     * Get field: position_product_view
     *
     * @return string
     */
    public function getPositionProductView()
    {
        return (string) $this->getData(self::PRODUCTLABEL_POSITION_PRODUCT_VIEW);
    }
    /**
     * Get field: display_on
     *
     * @return array
     */
    public function getDisplayOn()
    {
        $values = $this->getData(self::PRODUCTLABEL_DISPLAY_ON);
        if (is_numeric($values)) {
            $values = [$values];
        }
        return $values ? $values : [];
    }
    /**
     * Get field: is_active
     *
     * @return $this
     */
    public function setIsActive(bool $status)
    {
        return $this->setData(self::IS_ACTIVE, (bool) $status);
    }
    /**
     * Set field: product_label_id.
     *
     * @param int $value
     * @return $this
     */
    public function setProductLabelId($value)
    {
        return $this->setId((int) $value);
    }
    /**
     * Set field: identifier.
     *
     * @param string $value
     * @return $this
     */
    public function setIdentifier($value)
    {
        return $this->setData(self::PRODUCTLABEL_IDENTIFIER, (string) $value);
    }
    /**
     * Set field: name.
     *
     * @param string $value
     * @return $this
     */
    public function setName($value)
    {
        return $this->setData(self::PRODUCTLABEL_NAME, (string) $value);
    }
    /**
     * Set field: attribute_id.
     *
     * @param int $value
     * @return $this
     */
    public function setAttributeId(int $value)
    {
        return $this->setData(self::ATTRIBUTE_ID, $value);
    }
    /**
     * Set field: option_id.
     *
     * @param int $value
     * @return $this
     */
    public function setOptionId(int $value)
    {
        return $this->setData(self::OPTION_ID, $value);
    }
    /**
     * Set field: image.
     *
     * @param string $value
     * @return $this
     */
    public function setImage($value)
    {
        return $this->setData(self::PRODUCTLABEL_IMAGE, $value);
    }
    /**
     * Set field: position_category_list.
     *
     * @param string $value
     * @return $this
     */
    public function setPositionCategoryList($value)
    {
        return $this->setData(self::PRODUCTLABEL_POSITION_CATEGORY_LIST, $value);
    }
    /**
     * Set field: position_product_view.
     *
     * @param string $value
     * @return $this
     */
    public function setPositionProductView($value)
    {
        return $this->setData(self::PRODUCTLABEL_IMAGE, $value);
    }

    public function setDisplayOn($value)
    {
        return $this->setData(self::PRODUCTLABEL_DISPLAY_ON, $value);
    }
    /**
     * @param array $values
     */
    public function populateFromArray(array $values)
    {
        $this->setData(self::PRODUCTLABEL_IDENTIFIER, (string) $values['identifier']);
        $this->setData(self::PRODUCTLABEL_NAME, (string) $values['name']);
        $this->setData(self::ATTRIBUTE_ID, (int) $values['attribute_id']);
        $this->setData(self::OPTION_ID, (int) $values['option_id']);
        $this->setData(self::PRODUCTLABEL_IMAGE, $values['image'][0]['file']);
        $this->setData(self::PRODUCTLABEL_POSITION_CATEGORY_LIST, (string) $values['position_category_list']);
        $this->setData(self::PRODUCTLABEL_POSITION_PRODUCT_VIEW, (string) $values['position_product_view']);
        $this->setData(self::PRODUCTLABEL_DISPLAY_ON, (string) implode(';',$values['display_on']));
    }

    /**
     * @return bool|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getImageUrl()
    {
        $url = false;
        $image = $this->getData('image');
        if ($image) {
            if (is_string($image)) {
                $store = $this->storeManager->getStore();

                $isRelativeUrl = substr($image, 0, 1) === '/';

                $mediaBaseUrl = $store->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                );

                if ($isRelativeUrl) {
                    $url = $image;
                } else {
                    $url = $mediaBaseUrl
                        . ltrim(\Smile\ProductLabel\Model\ImageLabel\FileInfo::ENTITY_MEDIA_PATH, '/')
                        . '/'
                        . $image;
                }
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }

}