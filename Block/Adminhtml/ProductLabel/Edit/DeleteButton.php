<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Block\Adminhtml\ProductLabel\Edit;

/**
 * Adminhtml block: Button Delete
 */
class DeleteButton extends AbstractButton
{
    /**
     * @inheritdoc
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getObjectId()) {
            $message = __('Are you sure you want to delete this product label?');

            $data = [
                'label' => __('Delete Product Label'),
                'class' => 'delete',
                'on_click' => "deleteConfirm('{$message}', '{$this->getDeleteUrl()}')",
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    /**
     * Get URL for delete button
     */
    public function getDeleteUrl(): string
    {
        return $this->getUrl('*/*/delete', ['product_label_id' => $this->getObjectId()]);
    }
}
