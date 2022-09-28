<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Ui\Component\Source\Location;

use Smile\ProductLabel\Api\Data\ProductLabelInterface;

/**
 * Locations values for product label edit form.
 */
class View implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var array|null
     */
    private ?array $viewsList = null;

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        return $this->getViewsList();
    }

    /**
     * Retrieve list of attributes that can be used to define product labels.
     *
     * @return array
     */
    private function getViewsList(): array
    {
        $this->viewsList[0] = [
            'value'     => 0,
            'view_id'   => '',
            'label'     => '',
        ];

        $this->viewsList[1] = [
            'value'     => ProductLabelInterface::PRODUCTLABEL_DISPLAY_PRODUCT,
            'view_id'   => 'product_view',
            'label'     => 'Product View',
        ];

        $this->viewsList[2] = [
            'value'     => ProductLabelInterface::PRODUCTLABEL_DISPLAY_LISTING,
            'view_id'   => 'product_listing',
            'label'     => 'Product Listing',
        ];

        return $this->viewsList;
    }
}
