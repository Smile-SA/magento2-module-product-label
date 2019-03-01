<?php


namespace Smile\ProductLabel\Block\Adminhtml\ProductLabel\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Adminhtml block: Button Delete
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class DeleteButton extends AbstractButton implements ButtonProviderInterface
{
    /**
     * @inheritdoc
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getObjectId()) {
            $message = htmlentities(__('Are you sure you want to delete this product label?'));

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
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['product_label_id' => $this->getObjectId()]);
    }
}
