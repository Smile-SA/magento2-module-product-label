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
            'value'         => 0,
            'location_id'   => 'top_right',
            'label'         => 'Top Right',
        ];
        $this->locationsList[1] = [
            'value'         => 1,
            'location_id'   => 'top_left',
            'label'         => 'Top Left',
        ];
        $this->locationsList[2] = [
            'value'         => 2,
            'location_id'   => 'lower_right',
            'label'         => 'Lower Right',
        ];
        $this->locationsList[3] = [
            'value'         => 3,
            'location_id'   => 'lower_left',
            'label'         => 'Lower Left',
        ];
        return $this->locationsList;
    }
}