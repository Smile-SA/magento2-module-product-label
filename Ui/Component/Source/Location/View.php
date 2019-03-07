<?php

namespace Smile\ProductLabel\Ui\Component\Source\Location;

/**
 * Locations values for product label edit form.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class View implements \Magento\Framework\Data\OptionSourceInterface
{

    /**
     * @var array|null
     */
    private $viewsList;

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->getViewsList();
    }

    /**
     * Retrieve list of attributes that can be used to define virtual attributes rules.
     *
     * @return array
     */
    private function getViewsList()
    {

        $this->viewsList[0] = [
            'value'     => 0,
            'view_id'   => '',
            'label'     => '',
        ];
        $this->viewsList[1] = [
            'value'     => 1,
            'view_id'   => 'product_view',
            'label'     => 'Product View',
        ];
        $this->viewsList[2] = [
            'value'     => 2,
            'view_id'   => 'product_listing',
            'label'     => 'Product Listing',
        ];
        return $this->viewsList;
    }
}