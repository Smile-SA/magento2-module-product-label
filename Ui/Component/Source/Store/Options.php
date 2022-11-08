<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Ui\Component\Source\Store;

/**
 * Store Options for product label edit form.
 */
class Options extends \Magento\Store\Ui\Component\Listing\Column\Store\Options
{
    /**
     * All Store Views value
     */
    protected const ALL_STORE_VIEWS = '0';

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $this->currentOptions['All Store Views']['label'] = __('All Store Views');
        $this->currentOptions['All Store Views']['value'] = self::ALL_STORE_VIEWS;

        $this->generateCurrentOptions();

        $this->options = array_values($this->currentOptions);

        return $this->options;
    }
}
