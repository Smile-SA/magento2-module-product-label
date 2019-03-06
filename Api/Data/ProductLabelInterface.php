<?php

namespace Smile\ProductLabel\Api\Data;

/**
 * Product Label Data Interface
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
interface ProductLabelInterface
{
    /**
     * Name of the main Mysql Table
     */
    const TABLE_NAME = 'smile_productlabel';
    /**
     * Constant for field is_active
     */
    const IS_ACTIVE = 'is_active';
    /**
     * Constant for field product_label_id
     */
    const PRODUCTLABEL_ID = 'product_label_id';
    /**
     * Constant for field identifier
     */
    const PRODUCTLABEL_IDENTIFIER = 'identifier';
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
     * Get Identifier.
     *
     * @return string
     */
    public function getIdentifier();
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
    public function getAttributeId() : int;
    /**
     * Get option Id
     *
     * @return int
     */
    public function getOptionId() : int;
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
     * @return array $value
     */
    public function getDisplayOn();

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
     * @param int $value.
     *
     * @return ProductLabelInterface
     */
    public function setProductLabelId($value);
    /**
     * Set Identifier.
     *
     * @param string $value
     * @return $this
     */
    public function setIdentifier($value);
    /**
     * Set Name
     *
     * @param string $value.
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
}
