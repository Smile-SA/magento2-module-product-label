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

/**
 * Locations values for product label edit form.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class Options implements \Magento\Framework\Data\OptionSourceInterface
{

    /**
     * @var array|null
     */
    private $locationsList;

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->getLocationsList();
    }

    /**
     * Retrieve list of attributes that can be used to define product labels.
     *
     * @return array
     */
    private function getLocationsList()
    {
        $this->locationsList[0] = [
            'id'      => 0,
            'value'   => 'top_right',
            'label'   => 'Top Right',
        ];
        $this->locationsList[1] = [
            'id'      => 1,
            'value'   => 'top_left',
            'label'   => 'Top Left',
        ];
        $this->locationsList[2] = [
            'id'      => 2,
            'value'   => 'lower_right',
            'label'   => 'Lower Right',
        ];
        $this->locationsList[3] = [
            'id'      => 3,
            'value'   => 'lower_left',
            'label'   => 'Lower Left',
        ];

        return $this->locationsList;
    }
}
