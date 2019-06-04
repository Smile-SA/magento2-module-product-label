<?php
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Api\Data;

/**
 * Product Label Data Interface
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
interface ProductLabelInterface
{
    /**
     * Name of the main Mysql Table
     */
    const TABLE_NAME = 'smile_productlabel';

    /**
     * Name of the smile-productlabel-store association table
     */
    const STORE_TABLE_NAME = 'smile_productlabel_store';

    /**
     * Constant for field is_active
     */
    const IS_ACTIVE = 'is_active';

    /**
     * Constant for field product_label_id
     */
    const PRODUCTLABEL_ID = 'product_label_id';

    /**
     * Constant for field name
     */
    const PRODUCTLABEL_NAME = 'name';

    /**
     * Constant for field attribute_id
     */
    const ATTRIBUTE_ID = 'attribute_id';

    /**
     * Constant for field option_id
     */
    const OPTION_ID = 'option_id';

    /**
     * Constant for field image
     */
    const PRODUCTLABEL_IMAGE = 'image';

    /**
     * Constant for field position_category_list
     */
    const PRODUCTLABEL_POSITION_CATEGORY_LIST = 'position_category_list';

    /**
     * Constant for field position_product_view
     */
    const PRODUCTLABEL_POSITION_PRODUCT_VIEW = 'position_product_view';

    /**
     * Constant for field display_on
     */
    const PRODUCTLABEL_DISPLAY_ON = 'display_on';

    /**
     * If displayed on Product page
     */
    const PRODUCTLABEL_DISPLAY_PRODUCT = 1;

    /**
     * If displayed on Product listing
     */
    const PRODUCTLABEL_DISPLAY_LISTING = 2;

    /**
     * Alternative caption
     */
    const PRODUCTLABEL_ALT = 'alt';

    /**
     * Store Id(s)
     */
    const STORE_ID = 'store_id';

    /**
     * Retrieve product label store ids
     *
     * @return int[]
     */
    public function getStores();

    /**
     * Get product label status
     *
     * @return bool
     */
    public function isActive();

    /**
     * Get product label Id
     *
     * @return int
     */
    public function getProductLabelId();

    /**
     * Get product label Id
     *
     * @return int
     */
    public function getId();

    /**
     * Get Name
     *
     * @return string
     */
    public function getName();

    /**
     * Get attribute Id
     *
     * @return int
     */
    public function getAttributeId(): int;

    /**
     * Get option Id
     *
     * @return int
     */
    public function getOptionId(): int;

    /**
     * Get image
     *
     * @return string
     */
    public function getProductLabelImage();

    /**
     * Get position of image in category list
     *
     * @return string
     */
    public function getPositionCategoryList();

    /**
     * Get position of image in product view
     *
     * @return string
     */
    public function getPositionProductView();

    /**
     * Get display_on
     *
     * @return array
     */
    public function getDisplayOn();

    /**
     * Get Alternative caption
     *
     * @return string
     */
    public function getAlt();

    /**
     * Set product label status
     *
     * @param bool $status The product label status
     *
     * @return ProductLabelInterface
     */
    public function setIsActive(bool $status);

    /**
     * Set product label Id
     *
     * @param int $value The value
     *
     * @return ProductLabelInterface
     */
    public function setProductLabelId($value);

    /**
     * Set Name
     *
     * @param string $value The value
     *
     * @return ProductLabelInterface
     */
    public function setName($value);

    /**
     * Set attribute Id.
     *
     * @param int $value The attribute Id
     *
     * @return ProductLabelInterface
     */
    public function setAttributeId(int $value);

    /**
     * Set option Id.
     *
     * @param int $value The option Id
     *
     * @return ProductLabelInterface
     */
    public function setOptionId(int $value);

    /**
     * Set Image.
     *
     * @param string $value The product label Image
     *
     * @return ProductLabelInterface
     */
    public function setImage($value);

    /**
     * Set position_category_list.
     *
     * @param int $value The option Id
     *
     * @return ProductLabelInterface
     */
    public function setPositionCategoryList($value);

    /**
     * Set position_product_view.
     *
     * @param int $value The position product view
     *
     * @return ProductLabelInterface
     */
    public function setPositionProductView($value);

    /**
     * Set position_product_view.
     *
     * @param array $value The position product view
     *
     * @return ProductLabelInterface
     */
    public function setDisplayOn($value);

    /**
     * Set Alternative Caption
     *
     * @param string $value The value
     *
     * @return ProductLabelInterface
     */
    public function setAlt($value);
}
