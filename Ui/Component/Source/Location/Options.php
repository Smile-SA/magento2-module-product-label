<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Ui\Component\Source\Location;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Locations values for product label edit form.
 */
class Options implements OptionSourceInterface
{
    /**
     * @var array|null
     */
    private ?array $locationsList = null;

    /**
     * @inheritdoc
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
    private function getLocationsList(): array
    {
        $this->locationsList[0] = [
            'id'      => 0,
            'value'   => 'top-right',
            'label'   => 'Top Right',
        ];
        $this->locationsList[1] = [
            'id'      => 1,
            'value'   => 'top-left',
            'label'   => 'Top Left',
        ];
        $this->locationsList[2] = [
            'id'      => 2,
            'value'   => 'lower-right',
            'label'   => 'Lower Right',
        ];
        $this->locationsList[3] = [
            'id'      => 3,
            'value'   => 'lower-left',
            'label'   => 'Lower Left',
        ];

        return $this->locationsList;
    }
}
