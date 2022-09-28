<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Block\Adminhtml\ProductLabel\Edit;

/**
 * Adminhtml block: Button Back
 */
class BackButton extends AbstractButton
{
    /**
     * @inheritdoc
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10,
        ];
    }

    /**
     * Get URL for back (reset) button
     */
    public function getBackUrl(): string
    {
        return $this->getUrl('*/*/');
    }
}
