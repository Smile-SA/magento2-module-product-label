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
     * Get ID
     *
     * @return int|null
     */
    public function getId();
    /**
     * Get field: identifier.
     *
     * @return string
     */
    public function getIdentifier();
    /**
     * Get NAME
     *
     * @return string|null
     */
    public function getName();
    /**
     * Get attribute Id
     *
     * @return int
     */
    public function getAttributeId();
    /**
     * Get option Id
     *
     * @return int
     */
    public function getOptionId();
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
     * Set id
     *
     * @param int $productlabelId .
     *
     * @return ProductLabelInterface
     */
    public function setId($productlabelId);
    /**
     * Set identifier.
     *
     * @param string $value
     * @return $this
     */
    public function setIdentifier($value);
    /**
     * Set name
     *
     * @param string $productlabelName .
     *
     * @return ProductLabelInterface
     */
    public function setName($productlabelName);
    /**
     * Set attribute_id.
     *
     * @param int $attributeId The attribute Id
     *
     * @return ProductLabelInterface
     */
    public function setAttributeId($attributeId);
    /**
     * Set option_id.
     *
     * @param int $optionId The option Id
     *
     * @return ProductLabelInterface
     */
    public function setOptionId($optionId);
    /**
     * Set image.
     *
     * @param string $image The product label Image
     *
     * @return ProductLabelInterface
     */
    public function setImage($image);
    /**
     * Set position_category_list.
     *
     * @param int $positionCategoryList The option Id
     *
     * @return ProductLabelInterface
     */
    public function setPositionCategoryList($positionCategoryList);
    /**
     * Set position_product_view.
     *
     * @param int $positionProductView The position product view
     *
     * @return ProductLabelInterface
     */
    public function setPositionProductView($positionProductView);

}
