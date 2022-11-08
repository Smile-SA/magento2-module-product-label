<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Block\Adminhtml\ProductLabel\Edit;

/**
 * Adminhtml block: Button Reset
 */
class ResetButton extends AbstractButton
{
    /**
     * @inheritdoc
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30,
        ];
    }
}
