<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Ui\Component\Source\Location;

use Smile\ProductLabel\Api\Data\ProductLabelInterface;

/**
 * Locations values for product label edit form.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
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
     * Retrieve list of attributes that can be used to define product labels.
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
