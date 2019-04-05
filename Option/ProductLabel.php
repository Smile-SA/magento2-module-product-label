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

namespace Smile\ProductLabel\Option;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\Collection as ProductLabelCollection;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory as ProductLabelCollectionFactory;

/**
 * Class ProductLabel
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class ProductLabel extends AbstractSource
{

    /**
     * @var ProductLabelCollectionFactory
     */
    protected $productLabelCollectionFactory;

    /**
     * @var array
     */
    protected $options;


    public function __construct(ProductLabelCollectionFactory $productLabelCollectionFactory)
    {
        $this->productLabelCollectionFactory = $productLabelCollectionFactory;
    }


    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->options === null) {
            /**
             * @var $collection ProductLabelCollection
             */
            $collection = $this->productLabelCollectionFactory->create();
            $this->options = $collection->load()->getData();
        }

        return $this->options;
    }
}