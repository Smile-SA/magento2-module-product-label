<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Api\Data;

/**
 * Product Label Data Interface
 */
interface ProductLabelInterface
{
    /**
     * Name of the main Mysql Table
     */
    public const TABLE_NAME = 'smile_productlabel';

    /**
     * Name of the smile-productlabel-store association table
     */
    public const STORE_TABLE_NAME = 'smile_productlabel_store';

    /**
     * Constant for field is_active
     */
    public const IS_ACTIVE = 'is_active';

    /**
     * Constant for field product_label_id
     */
    public const PRODUCTLABEL_ID = 'product_label_id';

    /**
     * Constant for field name
     */
    public const PRODUCTLABEL_NAME = 'name';

    /**
     * Constant for field attribute_id
     */
    public const ATTRIBUTE_ID = 'attribute_id';

    /**
     * Constant for field option_id
     */
    public const OPTION_ID = 'option_id';

    /**
     * Constant for field image
     */
    public const PRODUCTLABEL_IMAGE = 'image';

    /**
     * Constant for field position_category_list
     */
    public const PRODUCTLABEL_POSITION_CATEGORY_LIST = 'position_category_list';

    /**
     * Constant for field position_product_view
     */
    public const PRODUCTLABEL_POSITION_PRODUCT_VIEW = 'position_product_view';

    /**
     * Constant for field display_on
     */
    public const PRODUCTLABEL_DISPLAY_ON = 'display_on';

    /**
     * If displayed on Product page
     */
    public const PRODUCTLABEL_DISPLAY_PRODUCT = 1;

    /**
     * If displayed on Product listing
     */
    public const PRODUCTLABEL_DISPLAY_LISTING = 2;

    /**
     * Alternative caption
     */
    public const PRODUCTLABEL_ALT = 'alt';

    /**
     * Store Id(s)
     */
    public const STORE_ID = 'store_id';

    /**
     * Retrieve product label store ids
     *
     * @return int[]
     */
    public function getStores(): array;

    /**
     * Get product label status
     *
     * @return bool
     */
    public function isActive(): bool;

    /**
     * Get product label Id
     *
     * @return int
     */
    public function getProductLabelId(): int;

    /**
     * Get product label Id
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Get Name
     *
     * @return string
     */
    public function getName(): string;

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
    public function getProductLabelImage(): string;

    /**
     * Get position of image in category list
     *
     * @return string
     */
    public function getPositionCategoryList(): string;

    /**
     * Get position of image in product view
     *
     * @return string
     */
    public function getPositionProductView(): string;

    /**
     * Get display_on
     *
     * @return array
     */
    public function getDisplayOn(): array;

    /**
     * Get Alternative caption
     *
     * @return string
     */
    public function getAlt(): string;

    /**
     * Set product label status
     *
     * @param bool $status The product label status
     * @return ProductLabelInterface
     */
    public function setIsActive(bool $status): ProductLabelInterface;

    /**
     * Set product label Id
     *
     * @param int $value The value
     * @return ProductLabelInterface
     */
    public function setProductLabelId(int $value): ProductLabelInterface;

    /**
     * Set Name
     *
     * @param string $value The value
     * @return ProductLabelInterface
     */
    public function setName(string $value): ProductLabelInterface;

    /**
     * Set attribute Id.
     *
     * @param int $value The attribute Id
     * @return ProductLabelInterface
     */
    public function setAttributeId(int $value): ProductLabelInterface;

    /**
     * Set option Id.
     *
     * @param int $value The option Id
     * @return ProductLabelInterface
     */
    public function setOptionId(int $value): ProductLabelInterface;

    /**
     * Set Image.
     *
     * @param string $value The product label Image
     * @return ProductLabelInterface
     */
    public function setImage(string $value): ProductLabelInterface;

    /**
     * Set position_category_list.
     *
     * @param int $value The option Id
     * @return ProductLabelInterface
     */
    public function setPositionCategoryList(int $value): ProductLabelInterface;

    /**
     * Set position_product_view.
     *
     * @param int $value The position product view
     * @return ProductLabelInterface
     */
    public function setPositionProductView(int $value): ProductLabelInterface;

    /**
     * Set position_product_view.
     *
     * @param array $value The position product view
     * @return ProductLabelInterface
     */
    public function setDisplayOn(array $value): ProductLabelInterface;

    /**
     * Set Alternative Caption
     *
     * @param string $value The value
     * @return ProductLabelInterface
     */
    public function setAlt(string $value): ProductLabelInterface;
}
