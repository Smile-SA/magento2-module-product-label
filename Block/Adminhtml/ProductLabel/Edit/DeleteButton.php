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

namespace Smile\ProductLabel\Block\Adminhtml\ProductLabel\Edit;

/**
 * Adminhtml block: Button Delete
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class DeleteButton extends AbstractButton
{
    /**
     * {@inheritdoc}
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
