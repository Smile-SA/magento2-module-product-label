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

namespace Smile\ProductLabel\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * Class Thumbnail
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    const NAME = 'thumbnail';

    const ALT_FIELD = 'name';

    /**
     * Thumbnail constructor.
     *
     * @param ContextInterface                           $context
     * @param UiComponentFactory                         $uiComponentFactory
     * @param \Smile\ProductLabel\Model\ImageLabel\Image $imageHelper
     * @param \Magento\Framework\UrlInterface            $urlBuilder
     * @param array                                      $components
     * @param array                                      $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Smile\ProductLabel\Model\ImageLabel\Image $imageHelper,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->imageHelper = $imageHelper;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {

                $item[$fieldName . '_src'] = $this->imageHelper->getBaseUrl().'/'.$item['image'];
                $item[$fieldName . '_alt'] = $this->getAlt($item) ?: $this->imageHelper->getLabel();
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    'smile_productlabel/productlabel/edit',
                    ['product_label_id' => $item['identifier']]
                );
                $item[$fieldName . '_orig_src'] = $this->imageHelper->getBaseUrl().'/'.$item['image'];
            }
        }

        return $dataSource;
    }

    /**
     * @param array $row
     *
     * @return null|string
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }

}