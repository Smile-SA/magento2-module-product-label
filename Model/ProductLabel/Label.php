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

namespace Smile\ProductLabel\Model\ProductLabel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Block\Product\AwareInterface as ProductAwareInterface;

/**
 * Service used to compute product label according to product type.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class Label implements ProductAwareInterface
{
    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * @var array
     */
    protected $productLabels = array();

    /**
     * @var array
     */
    protected $productHasLabel = array();

    /**
     * Constructor
     *
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        array $data = []
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Define if the discount should be shown.
     *
     * @return bool
     */
    public function hasLabel()
    {
        $productId = $this->getProduct()->getId();
        var_dump($this->getProduct()->getName());
        var_dump($this->productHasLabel[$productId]);
        var_dump($this->getProduct()->getTypeId());
        die('titi');
        if (!isset($this->productHasLabel[$productId])) {
            $this->productHasLabel[$productId] = false;
            $methodName = 'has' . ucfirst($this->getProduct()->getTypeId()) . 'ProductLabel';
            if (method_exists($this, $methodName)) {
                $this->productHasLabel[$productId] = $this->{$methodName}();
            }
        }
        return $this->productHasLabel[$productId];
    }

    /**
     * Returns discount percentage value.
     *
     * @return string
     */
    public function getLabel()
    {
        $productId = $this->getProduct()->getId();
        if (!isset($this->productLabels[$productId])) {
            $this->productLabels[$productId] = 0;
            $methodName = 'get' . ucfirst($this->getProduct()->getTypeId()) . 'ProductLabel';
            if (method_exists($this, $methodName)) {
                $this->productLabels[$productId] = $this->{$methodName}();
            }
        }
        return $this->productLabels[$productId];
    }

}
